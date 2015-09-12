-- Zasoby
INSERT INTO acl.resource (hash, name) VALUES(md5('game/profile'), 'game/profile');
INSERT INTO acl.resource (hash, name) VALUES(md5('home'), 'home');
INSERT INTO acl.resource (hash, name) VALUES(md5('user/login'), 'user/login');
INSERT INTO acl.resource (hash, name) VALUES(md5('user/logout'), 'user/logout');
INSERT INTO acl.resource (hash, name) VALUES(md5('user/register'), 'user/register');
INSERT INTO acl.resource (hash, name) VALUES(md5('user/register'), 'user/after-register');
INSERT INTO acl.resource (hash, name) VALUES(md5('user/register'), 'user/password-reminder');

-- Role
INSERT INTO acl.role (priority, name) VALUES(1, 'guest');
INSERT INTO acl.role (priority, name) VALUES(2, 'member');

-- Typy uprawien
INSERT INTO acl.permission_type (name) VALUES ('read');
INSERT INTO acl.permission_type (name) VALUES ('write');
INSERT INTO acl.permission_type (name) VALUES ('edit');
INSERT INTO acl.permission_type (name) VALUES ('execute');

-- Konkretne uprawnienia
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(1, 1, 1, false);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(1, 2, 1, false);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(1, 3, 1, false);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(1, 4, 1, false);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(1, 1, 2, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(1, 2, 2, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(1, 3, 2, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(1, 4, 2, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(2, 1, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(2, 2, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(2, 3, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(2, 4, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(3, 1, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(3, 2, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(3, 3, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(3, 4, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(4, 1, 1, false);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(5, 1, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(5, 1, 2, false);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(6, 1, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(6, 1, 2, false);

INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(3, 1, 2, false);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(4, 1, 2, true);


INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(7, 1, 1, true);
INSERT INTO acl.permission (resource_id, type_id, role_id, allow) VALUES(7, 1, 2, false);

-- Dziedziczenia
INSERT INTO acl.role_extension VALUES (2, 1);

-- Dodanie użytkownika
INSERT INTO "user".account (email, login, password) VALUES ('stedi2@o2.pl', 'YourFrog', md5('gitgit12'));

-- Dodanie uprawnień użytkownikowi
INSERT INTO "user".role VALUES(1, 2);