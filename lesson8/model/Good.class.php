<?php

class Good extends Model {
    protected static $table = 'goods';

    protected static function setProperties()
    {
        self::$properties['id'] = [
            'type' => 'int'
        ];

        self::$properties['name'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['price'] = [
            'type' => 'float'
        ];

        self::$properties['description'] = [
            'type' => 'text'
        ];

        self::$properties['category'] = [
            'type' => 'int'
        ];
    }

    public static function getGoods($categoryId=0)
    {
        return db::getInstance()->Select(
            "SELECT catalog.id as goodId, catalog.title as goodTitle, price, images.id as imageId, images.title as imageTitle FROM catalog LEFT JOIN images on images.good_id = catalog.id"
        );
    }

    public function getGoodInfo(){
        $sql = "SELECT catalog.id as goodId, catalog.title as goodTitle, description, price, images.title AS imageTitle, images.id as imageId FROM `catalog` LEFT JOIN images ON images.good_id = catalog.id WHERE catalog.id = :id";
        return db::getInstance()->Select($sql, ['id' => (int)$this->id])[0];
    }

    public function updateGood($params) {
        $pdoParams = [];
        $arrToStr = [];
        if ($params['title'] && $params['title']!=='') {
            $arrToStr[] = "title = :title";
            $pdoParams['title'] = $params['title'];
        }
        if ($params['price'] && $params['price']!=='') {
            $arrToStr[] = "price = :price";                    
            $pdoParams['price'] = $params['price'];
        }
        if ($params['description'] && $params['description']!=='') {
            $arrToStr[] = "description = :description";                    
            $pdoParams['description'] = $params['description'];
        }
        if ($params['id'] && $params['id']!==''){
            if (!count($pdoParams)){
                if (!$_FILES) {
                    return [
                        'success' => false,
                        'message' => "Не переданы параметры для обновления товара!"
                    ];
                } else {
                    $res = true;
                    $pdoParams['id'] = $params['id'];
                }
            } else {
                $pdoParams['id'] = $params['id'];
                $query = "UPDATE catalog SET ".implode(', ', $arrToStr)." WHERE id = :id";
                $res = db::getInstance()->Query($query, $pdoParams);
            }
        } else {
            if (count($pdoParams) <3 ) {
                return [
                    'success' => false,
                    'message' => "Не переданы параметры для создания товара!"
                ];
            } else {
                $query = "INSERT INTO catalog (title, price, description) VALUES (:title, :price, :description)";
            }
            $res = db::getInstance()->Query($query, $pdoParams);
            if (!$res) {
                return [
                    'success' => false,
                    'message' => "Не удается сохранить данные о новом товаре!"
                ];
            } else {
                $select = "SELECT id FROM catalog WHERE title = :title AND price = :price AND description = :description";
                $pdoParams['id'] = db::getInstance()->Select($select, $pdoParams)[0]['id'];
            }
        }
        if ($_FILES) $resPic = $this->addUpdatePhoto($pdoParams['id']);
        else $resPic = ['success' => true];
        if ($res && $resPic['success']) {
            return [
                'success' => true,
                'message' => "Данные о товаре успешно обновлены!"
            ];
        }else {
            return [
                'success' => false,
                'message' => "Не удается обновить данные о товаре! ".$resPic['message']
            ];
        }
    }

    private function addUpdatePhoto($goodId){
        $pathBig = $_SERVER['DOCUMENT_ROOT']."/lesson8/images/fullsize/";
        $pathSmall = $_SERVER['DOCUMENT_ROOT']."/lesson8/images/thumbnail/";
        if (!$_FILES['file']['error']) {
            if ($_FILES['file']['size'] > 5242880){
                $message = "Размер файла {$_FILES['file']['name']} превышает максимально допустимый размер в 5 МБ!";
                unlink($_FILES['file']['tmp_name']);
                return [
                    'success' => false,
                    'message' => $message
                ];
            }
            if(!move_uploaded_file($_FILES['file']['tmp_name'], $pathBig.$_FILES['file']['name'])) {
                $message = "Ошибка загрузки файла {$_FILES['file']['name']}!";
                unlink($_FILES['file']['tmp_name']);
                return [
                    'success' => false,
                    'message' => $message
                ];
            } else {
                $filename = $_FILES['file']['name'];
                $height = 200;
                list($width_orig, $height_orig) = getimagesize($pathBig.$filename);
                $ratio_orig = $width_orig/$height_orig;
                $width = $height * $ratio_orig;
                $filetype = explode('/', ($_FILES['file']['type']))[1];
                $imageSmall = imagecreatetruecolor($width, $height);
                switch($filetype){
                    case 'jpeg':
                        $imageBig = imagecreatefromjpeg($pathBig.$filename);
                        imagecopyresampled($imageSmall, $imageBig, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                        imagejpeg($imageSmall, $pathSmall.$filename);
                        break;
                    case 'png':
                        $imageBig = imagecreatefrompng($pathBig.$filename);
                        imagecopyresampled($imageSmall, $imageBig, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                        imagepng($imageSmall, $pathSmall.$filename);
                        break;
                    case 'gif':
                        $imageBig = imagecreatefromgif($pathBig.$filename);
                        imagecopyresampled($imageSmall, $imageBig, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                        imagegif($imageSmall, $pathSmall.$filename);
                        break;
                    default:
                        $message .= "$filetype - неизвестный либо недопустимый тип файла! ";
                        return [
                            'success' => false,
                            'message' => $message
                        ];
                }
            }
        }

        if ($filename) {
            $select = "select title from images where good_id = :good_id";
            $res = db::getInstance()->Select($select, ['good_id'=> $goodId]);
            if(count($res)) {
                $oldImageTitle = $res[0]['title'];
                if(!unlink($pathBig.$oldImageTitle)) {
                    $message .= "Не удалось удалить $oldImageTitle из $pathBig! ";
                }
                if(!unlink($pathSmall.$oldImageTitle)) {
                    $message .= "Не удалось удалить уменьшенный $oldImageTitle из $pathSmall! ";
                }
                $query = "update images set title = :title where good_id = :good_id";
            }else {
                $query = "insert into images (title, clicks, good_id) values (:title, 0, :good_id)";
            }           
            $params = [
                'good_id' => $goodId,
                'title' => $filename
            ];
            $res = db::getInstance()->Query($query, $params);

            if (!$res) {
                $message .= "Не удалось сохранить данные о $filename в базе данных!";
                return [
                    'success' => false,
                    'message' => $message
                ];
            } else {
                $message .= "Данные о $filename успешно сохранены в базе данных!";
                return [
                    'success' => true,
                    'message' => $message
                ];
            }
        }
    }

    public function deleteGood($id=0) {
        if (!$id) {
            return [
                'success' => false,
                'message' => 'Не указан id товара для удаления!'
            ];
        } else {
            $query = "DELETE FROM catalog WHERE id = :id";
            $res = db::getInstance()->Query($query, ['id' => $id]);
            if (!$res) {
                return [
                    'success' => false,
                    'message' => 'Не удается удалить информацию о товаре из базы данных!'
                ];
            }else {
                $select = "SELECT title FROM images WHERE good_id = :good_id";
                $res = db::getInstance()->Select($select, ['good_id' => $id]);
                if (count($res) !== 0) {
                    $filename = $res[0]['title'];
                    $query = "DELETE FROM images WHERE good_id = :good_id";
                    $res = db::getInstance()->Query($query, ['good_id' => $id]);
                    if (!$res) {
                        return [
                            'success' => false,
                            'message' => 'Не удается удалить информацию об изображении из базы данных!'
                        ];
                    } else {
                        $pathBig = $_SERVER['DOCUMENT_ROOT']."/lesson8/images/fullsize/";
                        $pathSmall = $_SERVER['DOCUMENT_ROOT']."/lesson8/images/thumbnail/";
                        if(!unlink($pathBig.$filename) || !unlink($pathSmall.$filename)) {
                            return [
                                'success' => false,
                                'message' => 'Не удается удалить картинку товара!'
                            ];
                        }else {
                            return [
                                'success' => true,
                                'message' => 'Товар успешно удален!'
                            ];
                        }
                    }
                } else {
                    return [
                        'success' => true,
                        'message' => 'Товар успешно удален!'
                    ];
                }
            }
        }
    }
}