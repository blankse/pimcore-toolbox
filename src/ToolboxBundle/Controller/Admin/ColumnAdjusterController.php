<?php

namespace ToolboxBundle\Controller\Admin;

use Pimcore\Bundle\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ToolboxBundle\Manager\ConfigManagerInterface;
use ToolboxBundle\Registry\CalculatorRegistryInterface;

class ColumnAdjusterController extends Controller\AdminController
{
    private CalculatorRegistryInterface $calculatorRegistry;
    private ConfigManagerInterface $configManager;

    public function __construct(
        ConfigManagerInterface $configManager,
        CalculatorRegistryInterface $calculatorRegistry
    ) {
        $this->configManager = $configManager;
        $this->calculatorRegistry = $calculatorRegistry;
    }

    /**
     * @throws \Exception
     */
    public function getColumnInfoAction(Request $request): JsonResponse
    {
        $currentColumn = $request->get('currentColumn');
        $customColumnConfigurationData = $request->get('customColumnConfiguration');

        $response = json_decode($customColumnConfigurationData, true);
        $customColumnConfiguration = null;

        if (is_array($response)) {
            $customColumnConfiguration = [$currentColumn => $response];
        }

        $theme = $this->configManager->getConfig('theme');
        $layout = isset($theme['layout']) ? strtolower($theme['layout']) : null;

        $columnCalculator = $this->calculatorRegistry->getColumnCalculator($theme['calculators']['column_calculator']);
        $breakPointConfiguration = $columnCalculator->getColumnInfoForAdjuster($currentColumn, $customColumnConfiguration);

        $gridSize = $this->assertGridConfig($theme, 'grid_size', 'integer');
        $columnStore = $this->assertGridConfig($theme, 'column_store', 'array');

        if (is_array($columnStore) && count($columnStore) === 0) {
            $columnStore = null;
        }

        return $this->json([
            'breakPoints' => $breakPointConfiguration,
            'gridSize'    => $gridSize,
            'columnStore' => $columnStore,
            'layout'      => $layout
        ]);
    }

    protected function assertGridConfig(array $theme, string $node, string $expectedType = 'string'): mixed
    {
        if (!isset($theme['grid'])) {
            return null;
        }

        if (!isset($theme['grid'][$node])) {
            return null;
        }

        if (gettype($theme['grid'][$node]) !== $expectedType) {
            return null;
        }

        return $theme['grid'][$node];
    }
}
