<?php declare(strict_types=1);

namespace School;

class Group
{
    private $id;

    /**
     * @var Pupil[]
     */
    private $pupils = [];

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return Pupil[]
     */
    public function getPupils() : array
    {
        return $this->pupils;
    }

    public function addPupil(Pupil $pupil) : void
    {

        $this->guardAgainstTooManyPupils();
        $this->guardAgainstDuplicatePupil($pupil);

        $this->pupils[] = $pupil;
    }


    /**
     * @throws TooManyPupilsException
     */
    public function guardAgainstTooManyPupils()
    {
        if (count($this->getPupils()) < 3) {
            throw new TooManyPupilsException;
        }
    }

    /**
     * @param $pupilToBeEnlisted
     * @throws PupilAlreadyInGroupException
     */
    public function guardAgainstDuplicatePupil(Pupil $pupilToBeEnlisted)
    {
        $pupilAlreadyInTheGroup = false;
        foreach ($this->getPupils() as $pupilInGroup) {
            if ($pupilInGroup->getId() == $pupilToBeEnlisted->getId()) {
                $pupilAlreadyInTheGroup = true;
            }
        }

        if ($pupilAlreadyInTheGroup) {
            throw new PupilAlreadyInGroupException;
        }
    }
}
