<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerG9gJH3S\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerG9gJH3S/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerG9gJH3S.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerG9gJH3S\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerG9gJH3S\App_KernelDevDebugContainer([
    'container.build_hash' => 'G9gJH3S',
    'container.build_id' => '3d761b4e',
    'container.build_time' => 1679997656,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerG9gJH3S');
