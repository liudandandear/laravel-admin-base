<?php

namespace AdminBase\Models;

use AdminBase\Utility\JsonHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Exception;

/**
 * 定义全局的 model 属性
 * Class BaseModel
 * @package App\Model
 */
class AdminBaseModel extends Model
{
    const RELEASE_YES = 1;
    const RELEASE_NO = 0;

    const STATUS_INIT = 0;
    const STATUS_ONLINE = 1;
    const STATUS_OFFLINE = 2;

    public static $statusLabel = [
        self::STATUS_INIT => '待审核',
        self::STATUS_ONLINE => '已通过',
        self::STATUS_OFFLINE => '审核失败',
    ];

    public static $statusLabelForm = [
        self::STATUS_ONLINE => '审核通过',
        self::STATUS_OFFLINE => '审核不通过',
    ];

    public static $releaseLabel = [
        self::RELEASE_NO => '否',
        self::RELEASE_YES => '是'
    ];

    protected $table = '';

    protected $dateFormat = '';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }

    /**
     * 获取map数组
     * @param int | string $id
     * @return array|string
     * @throws Exception
     */
    public static function columnAll($id = null)
    {
        if (!Cache::has(self::getCacheKey())) {
            $list = self::getAll();
            if ($list) {
                Cache::put(self::getCacheKey(), JsonHelper::encode($list), config('custom.cache_expire', 5));
            }
        } else {
            $list = JsonHelper::decode(Cache::get(self::getCacheKey()));
        }
        if (!is_null($id)){
            return $list[$id] ?? '';
        }
        return $list ?: [];
    }
}