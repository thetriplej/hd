<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter library handle for Crontab Manager
 *
 * @version 2013/10/29
 * @license LGPL v3 http://www.gnu.org/licenses/lgpl-3.0.txt
 * @copyright 2013 Philip Tschiemer, tschiemer@filou.se
 * @link https://github.com/tschiemer/ci-crontab
 */
require_once APPPATH . 'third_party/crontab.php.php';
class Crontab extends Crontab_Manager {

    public function __construct() {
//        씨 - 클론 타브
//CodeIgniter 용 Crontab 관리자 및 CLI 도우미
//
//풍모
//시스템 레벨 crontab과 직접 상호 작용하여 cronjob을 유지 관리합니다.
//        이들과 간섭하지 않도록 자신과 외부 cronjob에서 관리하는 cronjob을 구별합니다.
//        발신자가 고유하게 추가 / 제거 할 수있게 해주는 ID가있는 cronjob을 식별합니다.
//        oncecronjobs 허용 , 한 번만 .. 실행합니다.
//        cronjob에서 직접 호출 할 수 있도록 실제 cronjob에 대한 진입 점을 제공합니다 (예 : php /path/to/ci/application/third_party/cronjob.php --ci-job-id=abc --once 'controller/method/argument'
//CodeIgniter가없는 라이브러리로 사용
//CI 응용 프로그램 내에서 사용하기위한 것이지만 다른 방법으로 쉽게 사용할 수 있습니다. 관리자가 포함 된 주 파일은 CI 내에서 또는 cronjob에 의한 명령 줄에서 호출 될 것이라고 가정합니다. 그래서 그것을 다른 라이브러리에 통합하기 CRONTAB_AS_LIB위해 관리자를 포함하여 이전에 정의 할 수 있습니다 . 즉
//
//define('CRONTAB_AS_LIB',TRUE);
//require_once 'my/path/to/crontab.php';
//파일들
///application/third_party/crontab.php 관리자 및 CLI 부트 스트랩
//        /application/libraries/Crontab.php CI- 랩
//        /bin/crontab.php 관리자를위한 CLI (개념 입증)
//LGPLv3 라이센스
    }

}
/** End of file Crontab.php **/
/** Location: ./application/libraries/Crontab.php **/