<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerMEZX1e5\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerMEZX1e5/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerMEZX1e5.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerMEZX1e5\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerMEZX1e5\App_KernelDevDebugContainer([
    'container.build_hash' => 'MEZX1e5',
    'container.build_id' => '0e52a0f5',
    'container.build_time' => 1679999663,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerMEZX1e5');
