<?php declare(strict_types=1);

namespace School;

class GroupService
{
    /** @var GroupRepository */
    private $groupRepository;

    /** @var PupilRepository */
    private $pupilRepository;

    public function __construct(GroupRepository $groupRepository, PupilRepository $pupilRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->pupilRepository = $pupilRepository;
    }

    public function enlistPupilInGroup($groupId, $pupilId)
    {
        $group = $this->groupRepository->find($groupId);
        $pupilToBeEnlisted = $this->pupilRepository->find($pupilId);

        $this->guardAgainstTooManyPupils($group);
        $this->guardAgainstDuplicatePupil($group, $pupilToBeEnlisted);

        $group->addPupil($pupilToBeEnlisted);
        $this->groupRepository->persist($group);

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
