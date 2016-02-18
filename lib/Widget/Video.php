<?php
/*
 * Xibo - Digital Signage - http://www.xibo.org.uk
 * Copyright (C) 2006,2007,2008 Daniel Garner and James Packer
 *
 * This file is part of Xibo.
 *
 * Xibo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Xibo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Xibo.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Xibo\Widget;


use Xibo\Helper\Log;
use Xibo\Helper\Sanitize;

class Video extends ModuleWidget
{
    /**
     * Form for updating the module settings
     */
    public function settingsForm()
    {
        return 'video-form-settings';
    }

    /**
     * Process any module settings
     */
    public function settings()
    {
        // Process any module settings you asked for.
        $this->module->settings['defaultMute'] = Sanitize::getCheckbox('defaultMute');

        // Return an array of the processed settings.
        return $this->module->settings;
    }

    /**
     * Edit Media in the Database
     */
    public function edit()
    {
        // Set the properties specific to this module
        if (Sanitize::getCheckbox('playUntilEnd', 0) == 1)
            $this->setDuration(0);
        else
            $this->setDuration(Sanitize::getInt('duration', $this->getDuration()));

        $this->setOption('name', Sanitize::getString('name', $this->getOption('name')));
        $this->setOption('scaleType', Sanitize::getString('scaleTypeId', 'aspect'));
        $this->setOption('mute', Sanitize::getCheckbox('mute'));

        // Only loop if the duration is > 0
        if ($this->getDuration() == 0)
            $this->setOption('loop', 0);
        else
            $this->setOption('loop', Sanitize::getCheckbox('loop'));

        $this->saveWidget();
    }

    /**
     * Override previewAsClient
     * @param float $width
     * @param float $height
     * @param int $scaleOverride
     * @return string
     */
    public function previewAsClient($width, $height, $scaleOverride = 0)
    {
        return $this->previewIcon();
    }

    /**
     * Determine duration
     * @param $fileName
     * @return int
     */
    public function determineDuration($fileName = null)
    {
        // If we don't have a file name, then we use the default duration of 0 (end-detect)
        if ($fileName === null)
            return 0;

        Log::debug('Determine Duration from %s', $fileName);
        $info = new \getID3();
        $file = $info->analyze($fileName);
        return intval(Sanitize::getDouble('playtime_seconds', 0, $file));
    }

    /**
     * Set default widget options
     */
    public function setDefaultWidgetOptions()
    {
        $this->setOption('mute', $this->getSetting('defaultMute', 0));
    }

    /**
     * Get Resource
     * @param int $displayId
     * @return mixed
     */
    public function getResource($displayId = 0)
    {
        $this->download();
    }

    /**
     * Is this module valid
     * @return int
     */
    public function isValid()
    {
        // Yes
        return 1;
    }
}