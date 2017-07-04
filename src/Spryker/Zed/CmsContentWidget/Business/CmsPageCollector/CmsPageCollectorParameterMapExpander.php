<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsContentWidget\Business\CmsPageCollector;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Shared\CmsContentWidget\CmsContentWidgetConfig;
use Spryker\Zed\CmsContentWidget\Business\ContentWidget\ContentWidgetParameterMapperInterface;

class CmsPageCollectorParameterMapExpander implements CmsPageCollectorParameterMapExpanderInterface
{

    /**
     * @var \Spryker\Zed\CmsContentWidget\Business\ContentWidget\ContentWidgetParameterMapperInterface
     */
    protected $contentWidgetParameterMapper;

    /**
     * @param \Spryker\Zed\CmsContentWidget\Business\ContentWidget\ContentWidgetParameterMapperInterface $contentWidgetParameterMapper
     */
    public function __construct(ContentWidgetParameterMapperInterface $contentWidgetParameterMapper)
    {
        $this->contentWidgetParameterMapper = $contentWidgetParameterMapper;
    }

    /**
     * @param array $collectedData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return array
     */
    public function map(array $collectedData, LocaleTransfer $localeTransfer)
    {
        $collectedData[CmsContentWidgetConfig::CMS_CONTENT_WIDGET_PARAMETER_MAP] = $this->extractContentWidgetFunctionParameterMap(
            $collectedData['placeholders']
        );

        return $collectedData;
    }

    /**
     * @param array $contentPlaceholders
     *
     * @return array
     */
    protected function extractContentWidgetFunctionParameterMap(array $contentPlaceholders)
    {
        $contentWidgetParameterMap = [];
        foreach ($contentPlaceholders as $content) {
            $contentWidgetParameterMap = array_merge_recursive(
                $contentWidgetParameterMap,
                $this->contentWidgetParameterMapper->map($content)
            );
        }

        return $contentWidgetParameterMap;
    }

}
