<?php
class DetailController extends Controller
{

    public $view = 'detail';
    public $title;

    function __construct()
    {
        parent::__construct();
        $this->title .= ' - подробнее о котике';
    }

    public function index($data)
    {
        if (!$data['id']) {
            return ['error' => 'Отсутствует id товара'];
        } else {
            $good = New Good(['id' => $data['id']]);
            return ['good'=> $good->getGoodInfo()];
        }
    }
}
?>