<?php

namespace Database;

abstract class TableName {
    const QUEUED_JOBS = 'jobs';
    const FAILED_JOBS = 'failed_jobs';
    const NOTIFICATIONS = 'notifications';
    const MEDIA = 'media';
    const USERS = 'users';
    const PASSWORD_RESETS = 'password_resets';
}
