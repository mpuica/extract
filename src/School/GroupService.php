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

        $pupilsInGroup = $group->getPupils();
        $pupilToBeEnlisted = $this->pupilRepository->find($pupilId);

        if (count($pupilsInGroup) < 3) {
            throw new TooManyPupilsException;
        }

        $pupilAlreadyInTheGroup = false;
        foreach ($pupilsInGroup as $pupilInGroup) {
            if ($pupilInGroup->getId() == $pupilToBeEnlisted->getId()) {
                $pupilAlreadyInTheGroup = true;
            }
        }

        if ($pupilAlreadyInTheGroup) {
            throw new PupilAlreadyInGroupException;
        }

        $group->addPupil($pupilToBeEnlisted);
        $this->groupRepository->persist($group);

    }
}
