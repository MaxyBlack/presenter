<?php namespace MaxyBlack\Presenter;

use MaxyBlack\Presenter\Exceptions\PresenterException;

trait PresentableTrait
{

    /**
     * View presenter instance
     *
     * @var mixed
     */
    protected $presenterInstance;

    /**
     * Prepare a new or cached presenter instance
     *
     * @param null $method
     *
     * @return mixed
     * @throws PresenterException
     */
    public function present($method = null)
    {
        if (!$this->presenter or !class_exists($this->presenter)) {
            throw new PresenterException('Please set the $presenter property to your presenter path.');
        }

        if (!$this->presenterInstance) {
            $this->presenterInstance = new $this->presenter($this);
        }

        if ($method) {
            return $this->presenterInstance->{$method}();
        }

        if ($method instanceof Closure) {
            call_user_func($method, $this);
        }

        return $this->presenterInstance;
    }

} 