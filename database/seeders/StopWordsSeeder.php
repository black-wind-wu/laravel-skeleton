<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Larva\Censor\Models\StopWord;

/**
 * 反垃圾
 * @author Tongle Xu <xutongle@gmail.com>
 */
class StopWordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = scandir(database_path('data/stopwords'));
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;
            $content = file_get_contents(database_path('data/stopwords/' . $file));
            $words = explode("@", $content);
            $wordsLen = count($words);
            for ($i = 0; $i < $wordsLen; $i++) {
                $words[$i] = trim($words[$i]);
                if ((strlen($words[$i]) > 0 && !empty($words[$i])) && !StopWord::where('find', '=', $words[$i])->exists()) {
                    StopWord::create(['find' => $words[$i], 'ugc' => '{BANNED}']);
                }
            }
        }
    }
}
