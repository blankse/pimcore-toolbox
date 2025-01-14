<?php

namespace ToolboxBundle\Manager;

interface ConfigManagerInterface
{
    public const AREABRICK_NAMESPACE_INTERNAL = 'areas';
    public const AREABRICK_NAMESPACE_EXTERNAL = 'custom_areas';

    public function setConfig(array $config = []): void;

    public function setAreaNameSpace(string $namespace = self::AREABRICK_NAMESPACE_INTERNAL): self;

    /**
     * @throws \Exception
     */
    public function getConfig(string $section): mixed;

    /**
     * @throws \Exception
     */
    public function isContextConfig(): bool;

    /**
     * @throws \Exception
     */
    public function getCurrentContextSettings(): array;

    /**
     * @throws \Exception
     */
    public function getAreaConfig(string $areaName): mixed;

    /**
     * @throws \Exception
     */
    public function getAreaElementConfig(string $areaName, string $configElementName): mixed;

    /**
     * @throws \Exception
     */
    public function getAreaParameterConfig(string $areaName): mixed;

    /**
     * @throws \Exception
     */
    public function getImageThumbnailFromConfig(string $thumbnailName): ?string;

    public function getContextIdentifier(): ?string;
}
