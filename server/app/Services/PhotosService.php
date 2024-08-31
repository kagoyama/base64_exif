<?php
namespace App\Services;

use App\Repositories\PhotosRepository;
use App\Services\CommonService;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Support\Facades\Storage;

class PhotosService
{
    private $_photosRepository;
    private $_commonService;

    public function __construct(PhotosRepository $photosRepository,
                                CommonService $commonService)
    {
        $this->_photosRepository = $photosRepository;
        $this->_commonService = $commonService;
    }

    public function getPhotoList()
    {
        $photoList = $this->_photosRepository->getPhotoList();
        foreach ($photoList as $key => $val)
        {
            $val->upload_name = self::setUploadPath($val->user_id) . $val->upload_name;
        }
        return $photoList;
    }

    /**
     * 写真単体のデータを取得
     *
     * @param int $id
     * @return object|null
     */
    public function getPhotoDetail($id)
    {
        $photo = $this->_photosRepository->getPhotoDetail($id);
        // 画像に保存先のパスを加える
        $photo->upload_name = self::setUploadPath($photo->user_id) . $photo->upload_name;
        // https://www.google.com/maps?q=35.6812405,139.7649361
        $photo->gps_url = ($photo->gps !== null) ? 'https://www.google.com/maps?output=embed&t=m&q=' . $photo->gps : '';
        return $photo;
    }

    public function getPhotoExif($id)
    {
        $photo = $this->_photosRepository->getPhotoDetail($id);
        // 画像ファイルのパスを取得
        $filePath = self::setUploadPath($photo->user_id) . $photo->upload_name;
        // 画像ファイルの内容を読み込む
        $imageContent = Storage::get($filePath);
        // 画像のMIMEタイプを取得
        $mimeType = Storage::mimeType($filePath);
        // 画像データをbase64でエンコードし、MIMEタイプを含める
        $base64Encoded = 'data:' . $mimeType . ';base64,' . base64_encode($imageContent);
        // exifの中身表示
        $this->_commonService->decodeBase64Data($base64Encoded, 'exif');
    }

    /**
     * 写真を登録&保存
     *
     * @param object $request
     * @return string
     */
    public function registerPhotos($request)
    {
        $msgArr = [];
        foreach ($request->toArray() as $key => $val)
        {
            // dataをbase64からデコード
            $encodedData = $val['base64_encoded'];
            [$ext, $imageFile, $fileDateTime, $lat, $lon] = $this->_commonService->decodeBase64Data($encodedData);
            $fileDateTimeClass = new \DateTime($fileDateTime);
            // storageに保存するファイル名作成
            $fileDateTimeStr = $fileDateTimeClass->format('YmdHis');
            $uploadName = $fileDateTimeStr . $ext;
            // upsertに流すため$valに詰める
            $val['upload_name'] = $uploadName;
            $val['shot_date'] = $fileDateTimeClass->format('Y年m月d日 H時i分');
            // 緯度経度が取れなかった場合はnull
            $val['gps'] = (isset($lat) && isset($lon)) ? $lat . ',' . $lon : null;
            $upsertResult = self::upsertPhoto($val);

            $thisPhotoNum = $key + 1;
            // 保存に成功した場合
            if ($upsertResult === 1)
            {
                // アップロードするパス+画像名を作成
                $uploadPath = self::setUploadPath($val['user_id']) . $uploadName;
                // 画像をstorage下に保存
                Storage::put($uploadPath, $imageFile);
                $msgArr[$key] = $thisPhotoNum . '枚目を保存しました';
            }
            // 失敗時
            else
            {
                $msgArr[$key] = $thisPhotoNum . '枚目を保存できませんでした';
            }
        }

        return implode("\n", $msgArr);
    }

    /**
     * upsert用の配列を作成し実行する
     *
     * @param array $val
     * @return int
     */
    private function upsertPhoto($val)
    {
        $id = (isset($val['id'])) ? $val['id'] : null;
        $upsertData = [
            'id' => $id,
            'user_id' => $val['user_id'],
            'upload_name' => $val['upload_name'],
            'shot_date' => $val['shot_date'],
            'gps' => $val['gps'],
        ];
        return $this->_photosRepository->upsertData($upsertData);
    }

    /**
     * 画像をアップロードするパスを作成
     *
     * @param int $userId
     * @return string
     */
    private function setUploadPath($userId)
    {
        return config('photo.upload_path') . $userId . '/';
    }
}
