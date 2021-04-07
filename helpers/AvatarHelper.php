<?php

namespace app\helpers;

use Yii;
use yii\imagine\Image as Imagine;
use yii\web\UploadedFile;

class AvatarHelper
{
    /**
     * @param  $file_array
     * @param string $file_key
     * @param int $userID
     *
     * @return array
     */
    public static function saveAvatar($file_array, $file_key, $userID)
    {
        $image = $file = UploadedFile::getInstance($file_array, $file_key);

        if (empty($image)) {
            return [];
        }
        $uploadPath =  '/file-upload';
        $imagePath = 'file-upload';
        $extension = '.' . $image->extension;
        $fileName = self::randomString() . '_' . $userID;
        $sourceFile = $uploadPath . '/' . $fileName . $extension;

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $image->saveAs($sourceFile);

        Imagine::$driver = [Imagine::DRIVER_GD2, Imagine::DRIVER_GMAGICK, Imagine::DRIVER_IMAGICK];
        $sizes = [
            'small' => 48,
            'medium' => 96,
            'large' => 300,
        ];

        $avatars = [];

        foreach ($sizes as $alias => $size) {
            if($image->extension != 'gif')
            {
                $avatarUrl = $uploadPath . '/' . $fileName . '_' . $size . $extension;
                Imagine::thumbnail($sourceFile, $size, $size)->save($avatarUrl);
                $avatarUrl = $imagePath . '/' . $fileName . '_' . $size . $extension;
                $avatars[$alias] = '/' . $avatarUrl;
            }
            else
            {
                $avatarUrl = $uploadPath . '/' . $fileName . '_' . $size . $extension;
                $image->saveAs($avatarUrl);
                $avatars[$alias] = '/' . $imagePath . '/' . $fileName . $extension;
            }

        }

        return $avatars;
    }
/*
    public static function checkAvatar($file_avatar, $avatar, $remove_avatar = 0)
    {
        if (!empty($file_avatar)) {
            if ($avatar != '') {
                $avatar = self::removeAvatar($avatar);
            }
            $avatar = $file_avatar;
        } else {
            $avatar = (!empty($avatar)) ? $avatar : '';
        }

        if ($remove_avatar == 1) {
            $avatar = self::removeAvatar($avatar);
        }
        return $avatar;
    }

    protected static function removeAvatar($avatars)
    {
        echo 3;die;
        if (!empty($avatars)) {
            foreach ($avatars as $avatar) {
                $path = Yii::$app->params['backend_path'] . $avatar;
                if (file_exists($path)) {
                    unlink($path);
                }
                if (file_exists(Yii::getAlias('@webroot') . $avatar)) {
                    unlink(Yii::getAlias('@webroot') . $avatar);
                }
            }
            return '';
        }
        return $avatars;
    }
*/
    protected static function randomString($length = 32)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

}
