<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use App\Process\HotReload;
use App\Process\Task;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Rpc\NodeManager\FileManager;
use EasySwoole\Rpc\NodeManager\RedisManager;
use EasySwoole\Rpc\Rpc;
use EasySwoole\Rpc\Config as RpcConfig;
use EasySwoole\Rpc\Request as RpcRequest;
use EasySwoole\Rpc\Response as RpcResponse;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // 热重启
        $server = ServerManager::getInstance()->getSwooleServer();
//        $server->addProcess((new HotReload('reload', ['disableInotify' => false]))->getProcess());

        // 任务
//        $server->addProcess((new Task('text'))->getProcess());

        // rpc
        $rpcConfig = new RpcConfig();
        // 注册服务名称
        $rpcConfig->setServiceName('ser1');

        // 设置广播地址，可以多个地址
        $rpcConfig->getAutoFindConfig()->setAutoFindBroadcastAddress(['144.34.134.141:9600']);
        // 设置广播监听地址
        $rpcConfig->getAutoFindConfig()->setAutoFindListenAddress('144.34.134.141:9600');

//         $rpcConfig->setNodeManager(FileManager::class);
        $rpcConfig->setNodeManager(RedisManager::class);
        $rpcConfig->setExtra(['host' => '0.0.0.0', 'port' => 6379, 'auth' => 'zui']);

        $rpc = new Rpc($rpcConfig);
        // 注册响应方法
        $rpc->registerAction('call1', function (RpcRequest $request, RpcResponse$response) {
            // 获取请求参数
            dump($request->getArg());
            // 设置返回给客户端信息
            $response->setMessage('response111');
        });
        $rpc->registerAction('call2', function (RpcRequest $request, RpcResponse $response) {
            // 获取请求参数
            dump($request->getArg());
            // 设置返回给客户端信息
            $response->setMessage('response222');
        });

        // 监听/广播 rpc 自定义进程对象
        $autoFindProcess = $rpc->autoFindProcess('RpcProcess');
        // 增加自定义进程去监听/广播服务
        $server->addProcess($autoFindProcess->getProcess());
        // 起一个子服务去运行rpc
        ServerManager::getInstance()->addServer('rpc',9527);
        $rpc->attachToServer(ServerManager::getInstance()->getSwooleServer('rpc'));

    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}