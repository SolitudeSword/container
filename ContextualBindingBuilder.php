<?php

namespace Illuminate\Container;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualBindingBuilder as ContextualBindingBuilderContract;

/**
 * Class ContextualBindingBuilder
 * @package Illuminate\Container
 * 上下文绑定构建器
 */
class ContextualBindingBuilder implements ContextualBindingBuilderContract
{
    /**
     * The underlying container instance.
     * 底层容器实例
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * The concrete instance.
     * 要构建的实例名或实例名数组，完整类名
     *
     * @var string|string[]
     */
    protected $concrete;

    /**
     * The abstract target.
     * 抽象目标
     *
     * @var string
     */
    protected $needs;

    /**
     * Create a new contextual binding builder.
     * 创建一个新的上下文绑定构建器
     *
     * @param  \Illuminate\Contracts\Container\Container $container 底层容器
     * @param  string|array $concrete 要构建的实例名或实例名数组，完整类名
     * @return void
     */
    public function __construct(Container $container, $concrete)
    {
        $this->concrete = $concrete;
        $this->container = $container;
    }

    /**
     * Define the abstract target that depends on the context.
     * 定义依赖于上下文的抽象目标
     *
     * @param  string $abstract 抽象目标
     * @return $this
     */
    public function needs($abstract)
    {
        $this->needs = $abstract;

        return $this;
    }

    /**
     * Define the implementation for the contextual binding.
     * 定义上下文绑定的实现
     *
     * @param  \Closure|string $implementation 实现闭包或实例，闭包只接受一个参数是容器
     * @return void
     */
    public function give($implementation)
    {
        foreach (Arr::wrap($this->concrete) as $concrete) {
            $this->container->addContextualBinding($concrete, $this->needs, $implementation);
        }
    }
}
