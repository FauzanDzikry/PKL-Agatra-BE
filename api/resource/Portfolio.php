<?php

namespace app\resource;

class Portfolio extends \common\models\Blog
{
    public function extraFields()
    {
        return ['createdBy'];
    }


}