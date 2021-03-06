<?php

namespace Rybakit\Bundle\NavigationBundle\Navigation;

class NavigationItem extends AbstractItem
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var bool
     */
    protected $isActive = false;

    /**
     * @var bool
     */
    protected $isVisible = true;

    /**
     * @param string|null $label
     * @param string|null $uri
     */
    public function __construct($label = null, $uri = null)
    {
        parent::__construct();

        if (null !== $label) {
            $this->setLabel($label);
        }
        if (null !== $uri) {
            $this->setUri($uri);
        }
    }

    /**
     * @param string $label
     *
     * @return NavigationItem
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $uri
     *
     * @return NavigationItem
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param bool $active
     *
     * @return NavigationItem
     */
    public function setActive($active = true)
    {
        $this->isActive = (bool) $active;

        if ($this->isActive) {
            if ($this->getParent() instanceof self) {
                $this->getParent()->setActive();
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @return NavigationItem|null
     */
    public function getCurrent()
    {
        if ($this->isActive()) {
            foreach ($this->getIterator() as $item) {
                if ($item instanceof self && $item->isActive()) {
                    return $item->getCurrent();
                }
            }

            return $this;
        }

        return null;
    }

    /**
     * @param bool $visible
     *
     * @return NavigationItem
     */
    public function setVisible($visible = true)
    {
        $this->isVisible = (bool) $visible;

        foreach ($this->getIterator() as $item) {
            if ($item instanceof self) {
                $item->setVisible($visible);
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->isVisible;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->label;
    }
}
