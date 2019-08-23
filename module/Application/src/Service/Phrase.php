<?php

namespace Application\Service;

/**
 * Class Phrase
 */
class Phrase
{
    /**
     * Before and after phrase alias
     */
    const NONE = 'none';

    /**
     * Space-bar alias
     */
    const SPACE = 'space';

    /**
     * @var array
     */
    protected $info = [];

    /**
     * @var array
     */
    protected $charArray = [];

    /**
     * Analyze phrase
     *
     * @param string $text
     * @return $this
     */
    public function analyze($text)
    {
        $this->charArray = str_split(
            strtolower(
                trim($text)
            )
        );

        for ($i = 0; $i < count($this->charArray); $i++) {
            $this->addCharInfo($i);
        }

        return $this;
    }

    /**
     * Add info about character
     *
     * @param int $position
     */
    protected function addCharInfo($position)
    {
        $prevPos = $position - 1;
        $nextPos = $position + 1;

        $char = $this->charArray[$position];

        if (ctype_space($char)) {
            return;
        }

        if (!isset($this->info[$char])) {
            $this->info[$char] = [
                'after' => [],
                'before' => [],
                'position' => [],
            ];
        }

        array_push($this->info[$char]['position'], $position);

        $prevChar = isset($this->charArray[$prevPos]) ?
            (ctype_space($this->charArray[$prevPos]) ? self::SPACE : $this->charArray[$prevPos]) :
            self::NONE;
        array_push($this->info[$char]['after'], $prevChar);

        $nextChar = isset($this->charArray[$nextPos]) ?
            (ctype_space($this->charArray[$nextPos]) ? self::SPACE : $this->charArray[$nextPos]) :
            self::NONE;
        array_push($this->info[$char]['before'], $nextChar);
    }

    /**
     * Return phrase statistics
     *
     * @return array
     */
    public function getStatistics()
    {
        $statistics = [];

        foreach ($this->info as $char => $data) {
            $statistics[] = [
                'char' => $char,
                'qty' => count($data['position']),
                'before' => implode(', ', $data['before']),
                'after' => implode(', ', $data['after']),
                'max' => $this->getMaxDistance($data['position'])
            ];
        }

        return $statistics;
    }

    /**
     * Return max distance between chars
     *
     * @param array $data
     * @return int|null
     */
    protected function getMaxDistance(array $data)
    {
        $max = null;

        if (count($data) > 1) {
            $first = array_shift($data);
            foreach ($data as $position) {
                $distance = $position - $first - 1;
                $max = $distance >= $max ? $distance : $max;
                $first = $position;
            }
        }

        return $max;
    }
}
