<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerD1Sa3C1\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerD1Sa3C1/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerD1Sa3C1.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerD1Sa3C1\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerD1Sa3C1\App_KernelDevDebugContainer([
    'container.build_hash' => 'D1Sa3C1',
    'container.build_id' => 'eae1013c',
    'container.build_time' => 1680100541,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerD1Sa3C1');
