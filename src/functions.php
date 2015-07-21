<?php

if (!function_exists('sweet')) {
    /**
     * Arrange for an flash message.
     *
     * @param string|null $message
     *
     * @return \DraperStudio\SweetFlash\SweetFlashNotifier
     */
    function sweet($message = null)
    {
        $notifier = app('sweet-flash');

        if (!is_null($message)) {
            return $notifier->message($message);
        }

        return $notifier;
    }
}
