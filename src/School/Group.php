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

        $this->guardAgainstTooManyPupils($group);
        $this->guardAgainstDuplicatePupil($group, $pupilToBeEnlisted);

        $this->pupils[] = $pupil;
    }


    /**
     * @param $group
     * @throws TooManyPupilsException
     */
    public function guardAgainstTooManyPupils(Group $group)
    {
        if (count($group->getPupils()) < 3) {
            throw new TooManyPupilsException;
        }
    }

    /**
     * @param $group
     * @param $pupilToBeEnlisted
     * @throws PupilAlreadyInGroupException
     */
    public function guardAgainstDuplicatePupil(Group $group, Pupil $pupilToBeEnlisted)
    {
        $pupilAlreadyInTheGroup = false;
        foreach ($group->getPupils() as $pupilInGroup) {
            if ($pupilInGroup->getId() == $pupilToBeEnlisted->getId()) {
                $pupilAlreadyInTheGroup = true;
            }
        }

        if ($pupilAlreadyInTheGroup) {
            throw new PupilAlreadyInGroupException;
        }
    }
}
