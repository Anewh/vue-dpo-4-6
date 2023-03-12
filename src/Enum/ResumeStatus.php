<?php

namespace App\Enum;

class ResumeStatus
{
    public const NEW = 'level0';
    public const INTERVIEW_SCHEDULED = 'level1';
    public const ACCEPTED = 'level2';
    public const REJECTED = 'level3';
    public const STATUSES = [
        ResumeStatus::NEW,
        ResumeStatus::INTERVIEW_SCHEDULED,
        ResumeStatus::ACCEPTED,
        ResumeStatus::REJECTED,
    ];
}