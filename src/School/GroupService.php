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

        $group->addPupil($pupilToBeEnlisted);
        $this->groupRepository->persist($group);

    }

}
