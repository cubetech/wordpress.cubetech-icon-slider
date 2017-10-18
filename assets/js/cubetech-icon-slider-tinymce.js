tinymce.create(
    'tinymce.plugins.cubetech_icon_slider', {
        /**
         * @param tinymce.Editor editor
         * @param string url
         */
        init: function(editor, url) {
            /**
             *  register a new button
             */
            editor.addButton(
                'cubetech_icon_slider_button', {
                    cmd: 'cubetech_icon_slider_button_cmd',
                    title: editor.getLang('cubetech_icon_slider.buttonTitle', 'cubetech Icon Slider'),
                    image: url + '/../img/toolbar-icon.png'
                }
            );
            /**
             * and a new command
             */
            editor.addCommand(
                'cubetech_icon_slider_button_cmd',
                function() {
                    /**
                     * @param Object Popup settings
                     * @param Object Arguments to pass to the Popup
                     */
                    editor.windowManager.open({
                        // this is the ID of the popups parent element
                        id: 'cubetech_icon_slider_dialog',
                        width: 480,
                        title: editor.getLang('cubetech_icon_slider.popupTitle', 'cubetech Icon Slider'),
                        height: 'auto',
                        wpDialog: true,
                        display: 'block',
                    }, {
                        plugin_url: url
                    });
                }
            );
        }
    }
);

// register plugin
tinymce.PluginManager.add('cubetech_icon_slider', tinymce.plugins.cubetech_icon_slider);