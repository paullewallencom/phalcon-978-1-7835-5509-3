<?php
namespace App\Core\Models\Mongo;

class ArticleLog extends BaseCollection
{
    public $article_id;

    public $client_ip;

    public $user_agent;

    public $timestamp;

    public function getSource()
    {
        return 'article_log';
    }

    public function log($article_id, \Phalcon\Http\Request $request)
    {
        $log = new self();
        $log->article_id = (int) $article_id;
        $log->client_ip  = $request->getClientAddress();
        $log->user_agent = $request->getUserAgent();
        $log->timestamp  = time();

        $log->save();
    }

    public function countVisits($article_id, $unique = false)
    {
        if (false === $unique) {
            return $this->count(array(
                array(
                    "article_id" => $article_id
                )
            ));
        } else {
            $result = $this->getConnection()->command(
                array(
                    'distinct' => 'article_log',
                    'key' => 'client_ip',
                    'query' => ['article_id' => $article_id],
                )
            );

            return count($result['values']);
        }
    }

    public function columnMap()
    {
        return [
            'article_id' => 'article_id',
            'client_ip'  => 'client_ip',
            'user_agent' => 'user_agent',
            'timestamp'  => 'timestamp',
        ];
    }
}
