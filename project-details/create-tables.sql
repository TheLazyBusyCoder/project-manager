-- =====================================================
-- Project Management Tool - Database Schema (MySQL)
-- =====================================================

-- 1. USERS
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','project_manager','developer','tester') NOT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    manager_id BIGINT UNSIGNED,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================

-- 2. PROJECTS
CREATE TABLE projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_manager_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    priority ENUM('low','medium','high','critical') DEFAULT 'medium',
    status ENUM('planned','in_progress','on_hold','completed','cancelled') DEFAULT 'planned',
    start_date DATE,
    end_date DATE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_projects_pm FOREIGN KEY (project_manager_id) REFERENCES users(id)
);

-- =====================================================

-- 3. MODULES (RECURSIVE)
CREATE TABLE modules (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    parent_module_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('not_started','in_progress','blocked','completed') DEFAULT 'not_started',
    progress INT DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_modules_project FOREIGN KEY (project_id) REFERENCES projects(id),
    CONSTRAINT fk_modules_parent FOREIGN KEY (parent_module_id) REFERENCES modules(id)
);

-- =====================================================

-- 4. TASKS (RECURSIVE)
CREATE TABLE tasks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    module_id BIGINT UNSIGNED NOT NULL,
    parent_task_id BIGINT UNSIGNED NULL,
    assigned_to BIGINT UNSIGNED NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    task_type ENUM('development','bug_fix','testing') NOT NULL,
    priority ENUM('low','medium','high','critical') DEFAULT 'medium',
    status ENUM('todo','in_progress','code_review','testing','reopened','done') DEFAULT 'todo',
    estimated_hours DECIMAL(5,2),
    actual_hours DECIMAL(5,2),
    due_date DATE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_tasks_project FOREIGN KEY (project_id) REFERENCES projects(id),
    CONSTRAINT fk_tasks_module FOREIGN KEY (module_id) REFERENCES modules(id),
    CONSTRAINT fk_tasks_parent FOREIGN KEY (parent_task_id) REFERENCES tasks(id),
    CONSTRAINT fk_tasks_assigned FOREIGN KEY (assigned_to) REFERENCES users(id),
    CONSTRAINT fk_tasks_creator FOREIGN KEY (created_by) REFERENCES users(id)
);

-- =====================================================

-- 5. MODULE TESTERS (MANY TO MANY)
CREATE TABLE module_testers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    module_id BIGINT UNSIGNED NOT NULL,
    tester_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_module_testers_module FOREIGN KEY (module_id) REFERENCES modules(id),
    CONSTRAINT fk_module_testers_tester FOREIGN KEY (tester_id) REFERENCES users(id),
    UNIQUE KEY unique_module_tester (module_id, tester_id)
);

-- =====================================================

-- 6. TASK COMMENTS (RECURSIVE / LINKED LIST)
CREATE TABLE task_comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id BIGINT UNSIGNED NOT NULL,
    parent_comment_id BIGINT UNSIGNED NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    comment TEXT NOT NULL,
    comment_type ENUM('general','issue','suggestion','blocker') DEFAULT 'general',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_comments_task FOREIGN KEY (task_id) REFERENCES tasks(id),
    CONSTRAINT fk_comments_parent FOREIGN KEY (parent_comment_id) REFERENCES task_comments(id),
    CONSTRAINT fk_comments_user FOREIGN KEY (user_id) REFERENCES users(id)
);

-- =====================================================

-- 7. TASK ATTACHMENTS
CREATE TABLE task_attachments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id BIGINT UNSIGNED NOT NULL,
    uploaded_by BIGINT UNSIGNED NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type VARCHAR(100),
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_attachments_task FOREIGN KEY (task_id) REFERENCES tasks(id),
    CONSTRAINT fk_attachments_user FOREIGN KEY (uploaded_by) REFERENCES users(id)
);

-- =====================================================

-- 8. ACTIVITY LOGS (AUDIT TRAIL)
CREATE TABLE activity_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    entity_type VARCHAR(50) NOT NULL,
    entity_id BIGINT UNSIGNED NOT NULL,
    action VARCHAR(100) NOT NULL,
    old_value JSON NULL,
    new_value JSON NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_activity_user FOREIGN KEY (user_id) REFERENCES users(id)
);

-- =====================================================

-- 9. NOTIFICATIONS
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    entity_type VARCHAR(50),
    entity_id BIGINT UNSIGNED,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) REFERENCES users(id)
);

-- =====================================================

-- 10. TASK TIME LOGS
CREATE TABLE task_time_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    hours DECIMAL(5,2) NOT NULL,
    log_date DATE NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_timelogs_task FOREIGN KEY (task_id) REFERENCES tasks(id),
    CONSTRAINT fk_timelogs_user FOREIGN KEY (user_id) REFERENCES users(id)
);

-- =====================================================

-- 11. TAGS
CREATE TABLE tags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================

-- 12. TASK TAGS (MANY TO MANY)
CREATE TABLE task_tags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id BIGINT UNSIGNED NOT NULL,
    tag_id BIGINT UNSIGNED NOT NULL,
    CONSTRAINT fk_task_tags_task FOREIGN KEY (task_id) REFERENCES tasks(id),
    CONSTRAINT fk_task_tags_tag FOREIGN KEY (tag_id) REFERENCES tags(id),
    UNIQUE KEY unique_task_tag (task_id, tag_id)
);

-- =====================================================
-- END OF SCHEMA
-- =====================================================
