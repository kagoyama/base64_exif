<?php
namespace App\Repositories;

use App\Models\Photos;

class PhotosRepository
{
    private $_photos;

    public function __construct(Photos $photos)
    {
        $this->_photos = $photos;
    }

    public function find($id)
    {
        return $this->_photos->find($id);
    }

    public function getPhotoList()
    {
        return $this->_photos->getDataDescId();
    }

    public function getPhotoDetail($id)
    {
        return $this->_photos->getDataById($id);
    }

    /**
     * upsert処理
     *
     * @param array $upsertData
     * @return integer
     */
    public function upsertData($upsertData)
    {
        return $this->_photos->upsertData($upsertData, ['id']);
    }
}
