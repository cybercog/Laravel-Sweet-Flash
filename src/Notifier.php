<?php

namespace DraperStudio\SweetFlash;

use Illuminate\Session\Store;

class Notifier
{
    /**
     * @var Store
     */
    private $session;

    /**
     * @var array
     */
    private $config = [
        'allowOutsideClick' => true,
        'showConfirmButton' => false,
        'timer' => 1800,
    ];

    /**
     * @var string
     */
    private $callback;

    /**
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Displays a simple flash with a message and an optional title.
     *
     * @param $text
     * @param string $type
     * @param string $title
     *
     * @return $this
     */
    public function message($text, $type = 'info', $title = '')
    {
        return $this->config('text', $text)
                    ->config('type', $type)
                    ->config('title', $title)
                    ->commit();
    }

    /**
     * Displays a success flash.
     *
     * @param $text
     * @param string $title
     *
     * @return $this
     */
    public function success($text, $title = '')
    {
        return $this->message($text, 'success', $title);
    }

    /**
     * Displays an info flash.
     *
     * @param $text
     * @param string $title
     *
     * @return $this
     */
    public function info($text, $title = '')
    {
        return $this->message($text, 'info', $title);
    }

    /**
     * Displays an warning flash.
     *
     * @param $text
     * @param string $title
     *
     * @return $this
     */
    public function warning($text, $title = '')
    {
        return $this->message($text, 'warning', $title);
    }

    /**
     * Displays an error flash.
     *
     * @param $text
     * @param string $title
     *
     * @return $this
     */
    public function error($text, $title = '')
    {
        return $this->message($text, 'error', $title);
    }

    /**
     * Sets the time for this flash to close.
     *
     * @param int $milliseconds
     *
     * @return $this
     */
    public function autoclose($milliseconds = 2000)
    {
        return $this->config('timer', $milliseconds)
                    ->commit();
    }

    /**
     * Shows an flash that prevents autoclosing.
     *
     * @param string $buttonText
     *
     * @return $this
     */
    public function persistent($buttonText = 'OK')
    {
        return $this->config('confirmButtonText', $buttonText)
                    ->config('showConfirmButton', true)
                    ->config('allowOutsideClick', false)
                    ->config('timer', 'null')
                    ->commit();
    }

    /**
     * Set a callback that should be used by swal().
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function callback($value)
    {
        $this->callback = $value;

        return $this;
    }

    /**
     * Set the value of an option in the configuration.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return $this
     */
    public function config($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->config($k, $v);
            }
        } else {
            $this->config[$key] = $value;
        }

        return $this;
    }

    /**
     * Flashes the current built configuration for sweet flash.
     *
     * @return $this
     */
    public function commit()
    {
        foreach ($this->config as $key => $value) {
            $this->session->flash("sweet_flash.{$key}", $value);
        }

        $this->session->flash('sweet_flash.flash', json_encode($this->config));

        if (!empty($this->callback)) {
            $this->session->flash('sweet_flash.callback', $this->callback);
        }

        return $this;
    }

    /**
     * "Helper"-method for building alerts with a custom configuration.
     *
     * @param array $config
     *
     * @return $this
     */
    public function custom($config)
    {
        return $this->config($config)
                    ->commit();
    }
}
