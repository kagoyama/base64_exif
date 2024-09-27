<?php
namespace App\Services;

class CommonService
{
    /**
     * base64エンコードされたデータをデコードして
     * 拡張子とデコードしたデータを返す
     *
     * @param string $encodedData
     * @return array
     */
    public function decodeBase64Data($encodedData, $mode='')
    {
        // [
        //     'data:image/png',
        //     'base64,...'
        // ]
        $encodedDataList = explode(';', $encodedData);
        $mediaType = explode('/', $encodedDataList[0])[0]; // 'data:image' または 'data:video'
        $ext = '.' . explode('/', $encodedDataList[0])[1]; // 拡張子 (.png, .mp4 など)

        if ($mediaType === 'data:image')
        {
            $exif = exif_read_data($encodedData);
            if ($mode === 'exif')
            {
                dd($encodedData, $encodedDataList, $exif);
            }
            if (isset($exif['GPSLatitudeRef']))
            {
                $lat = $this->gpsToNumber($exif['GPSLatitude'], $exif['GPSLatitudeRef']);
                $lon = $this->gpsToNumber($exif['GPSLongitude'], $exif['GPSLongitudeRef']);
            }
            else
            {
                $lat = null;
                $lon = null;
            }
            $encodedDataList = explode(';', $encodedData);
            // .png
            $ext = '.' . explode('/', $encodedDataList[0])[1];
            $decodeTargetData = str_replace('base64,', '', $encodedDataList[1]);
            $image = base64_decode($decodeTargetData);
            return [$ext, $image, $exif['DateTime'], $lat, $lon];
        }
        else if ($mediaType === 'data:video')
        {
            //
        }
        return null;
    }

    /**
     * GPS座標を数値に変換する by chatGpt
     *
     * @param array $gps GPS座標
     * @param string $ref 方向参照（N, S, E, W）
     * @return float
     */
    private function gpsToNumber($gps, $ref)
    {
        $degrees = count($gps) > 0 ? $this->convertDMSToDecimal($gps[0]) : 0;
        $minutes = count($gps) > 1 ? $this->convertDMSToDecimal($gps[1]) : 0;
        $seconds = count($gps) > 2 ? $this->convertDMSToDecimal($gps[2]) : 0;

        $flip = ($ref == 'W' || $ref == 'S') ? -1 : 1;
        return $flip * ($degrees + ($minutes / 60) + ($seconds / 3600));
    }

    /**
     * DMS（度分秒）形式のデータを10進数に変換 by chatGpt
     *
     * @param string $dms 度分秒
     * @return float
     */
    private function convertDMSToDecimal($dms)
    {
        $parts = explode('/', $dms);
        if (count($parts) <= 0) return 0;
        if (count($parts) == 1) return (float)$parts[0];
        return (float)$parts[0] / (float)$parts[1];
    }
}
