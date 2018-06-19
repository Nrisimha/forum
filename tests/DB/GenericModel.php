<?php
namespace Tests\DB;

use Pharango\Model;
use Pharango\Document;

class GenericModel extends Model
{
  protected $collectionName = "test_phpunit";
}

/* 

_id:test_phpunit/sample
_rev:11753740
_key:sample

{
  "data": "exist",
	"type": "donut",
	"name": "Cake",
	"amount":555,
	"image":
		{
			"url": "images/0001.jpg",
			"width": 200,
			"height": 200
		},
	"thumbnail":
		{
			"url": "images/thumbnails/0001.jpg",
			"width": 32,
			"height": 32
		}
}

*/