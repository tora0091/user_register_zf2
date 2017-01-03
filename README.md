#Zendframework2 学習用アプリケーション

PHPUnitでのテストコード実行環境を構築する際にはまったのでメモ  

*エラーメッセージ*

PHP Fatal error:  Uncaught exception 'Zend\ModuleManager\Exception\RuntimeException' with message 'Module (UserRegister) could not be initialized

作成したClassをcomposer.jsonに記載することで解決、なおその際、composer.jsonでの再構築が必要(php composer.phar update)

*エラーメッセージ*

PHP Fatal error:  Uncaught exception 'Zend\Config\Exception\RuntimeException' with message 'Filename "C:[UserPath]\module\UserRegister\test/../../../config/autoload/" is missing an extension and cannot be auto-detected' in C:[UserPath]\vendor\zendframework\zend-config\src\Factory.php:94

Unitテスト用のBootstrap.phpでのConfファイル設定が間違っていた

正：$config['module_listener_options']['config_glob_paths'][0] = sprintf(__DIR__ . "/../../../config/autoload/{,*.}{global,local,%s}.php", $env);

誤：$config['module_listener_options']['config_glob_paths'][0] = sprintf(__DIR__ . "/../../../config/autoload/{,*.}{global,local,%s", $env);

*エラーメッセージ*

PHP Fatal error:  Uncaught exception 'Zend\ServiceManager\Exception\ServiceNotFoundException' with message 'Zend\ServiceManager\ServiceManager::get was unable to fetch or create an instance for Zend\Db\Adapter\Adapter' in C:[UserPath]\vendor\zendframework\zend-servicemanager\src\ServiceManager.php:555

Zend\Db\Adapter\Adapterの取得をアプリケーション側ではNewしていたが、Unitテストのことも考慮に入れ、ServiceManager経由にすることで解決
