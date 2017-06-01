BEGIN TRANSACTION;
CREATE TABLE "users" (
	`id`	INTEGER,
	`username`	TEXT NOT NULL UNIQUE,
	`password`	TEXT NOT NULL,
	PRIMARY KEY(id)
);
INSERT INTO `users` (id,username,password) VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997');
CREATE TABLE `posts` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`category_id`	INTEGER NOT NULL,
	`user_id`	INTEGER NOT NULL,
	`name`	TEXT,
	`slug`	TEXT,
	`content`	TEXT,
	`created`	NUMERIC NOT NULL
);
INSERT INTO `posts` (id,category_id,user_id,name,slug,content,created) VALUES (2,1,1,'My name is Alex','my-name-is-alex','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nec enim erat. Integer malesuada tincidunt mauris, at bibendum leo. Pellentesque velit neque, mattis quis metus nec, tristique posuere odio. Pellentesque consectetur dui vulputate, placerat arcu sed, sollicitudin neque. Etiam porta urna vitae luctus fringilla. Nulla facilisi. Etiam id nisi metus. Sed volutpat euismod est sed aliquam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer porttitor tempor massa, pellentesque fringilla quam interdum et. Phasellus gravida sollicitudin quam, dignissim condimentum metus bibendum quis. Mauris lacinia, massa eget auctor efficitur, turpis ipsum congue tellus, at ultrices arcu ante tincidunt tellus. Mauris iaculis accumsan elit, sodales efficitur velit tristique quis. 

Nunc quis massa a ligula ullamcorper dapibus. Suspendisse non turpis gravida, ultrices odio eget, maximus massa. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce ut velit eget eros posuere lobortis vitae a ipsum. Pellentesque laoreet aliquet nibh, et dignissim ipsum molestie gravida. Duis eu lacinia massa. Nunc eget arcu a nulla euismod molestie eget vel enim. Aliquam erat volutpat. Integer laoreet leo purus, vitae malesuada diam tempor vitae. 

Donec at massa et neque auctor congue. Quisque finibus eu mi quis viverra. Curabitur vel ligula sit amet libero faucibus ultrices sit amet sed libero. Fusce ultricies et dolor at porttitor. Morbi eu pretium leo, a porttitor ante. Etiam magna ligula, convallis a nisi vel, placerat varius diam. Proin feugiat nisi non turpis rhoncus, vitae egestas odio finibus. Nullam quis aliquet risus. Cras ultrices sed metus eget dignissim. Mauris rhoncus, augue at rhoncus congue, dolor leo euismod libero, ac gravida velit turpis non diam. Praesent vestibulum tellus ac turpis commodo tincidunt. Quisque hendrerit, orci at cursus semper, nisl arcu ultricies felis, at mollis libero metus aliquam dolor. In eget sem malesuada odio lobortis sagittis. 

Vivamus consectetur, enim vitae blandit tempor, dui velit hendrerit enim, non ornare mauris purus non eros. Donec aliquet varius mauris vitae porta. Etiam lobortis placerat lectus ut semper. Nam malesuada mollis dui, non blandit metus feugiat quis. Sed in ligula sed ligula volutpat vestibulum eget ac eros. Etiam pellentesque auctor nisl, vel scelerisque magna maximus bibendum. Pellentesque placerat diam faucibus mi accumsan elementum. Nunc sed dui diam. Suspendisse est dolor, pellentesque sed molestie in, rutrum rhoncus dui. Mauris velit lectus, vestibulum id quam eget, malesuada lacinia est. Etiam varius iaculis quam, sed scelerisque libero egestas id. Donec congue lacus ligula. Curabitur ornare, lorem sed ultrices sagittis, nibh metus laoreet risus, id vestibulum sapien neque in leo. 

Fusce rutrum neque eu viverra aliquam. Aliquam tristique feugiat mauris, dapibus consequat nisl faucibus id. Fusce vestibulum maximus mi, nec mollis lorem congue mollis. Quisque vitae euismod erat, suscipit molestie elit. Pellentesque euismod vitae magna eget semper. Vestibulum justo lacus, bibendum vel feugiat non, lacinia in nibh. Praesent nec aliquet magna, ut maximus diam. Aliquam cursus ultricies leo quis consequat. Nam nec leo mauris. Mauris lobortis nunc ex, vitae efficitur ligula facilisis eget. In varius non purus eget rhoncus.',1483351781),
 (3,1,1,'I''m a web developer bicth','i''m-a-web-developer-bicth','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nec enim erat. Integer malesuada tincidunt mauris, at bibendum leo. Pellentesque velit neque, mattis quis metus nec, tristique posuere odio. Pellentesque consectetur dui vulputate, placerat arcu sed, sollicitudin neque. Etiam porta urna vitae luctus fringilla. Nulla facilisi. Etiam id nisi metus. Sed volutpat euismod est sed aliquam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer porttitor tempor massa, pellentesque fringilla quam interdum et. Phasellus gravida sollicitudin quam, dignissim condimentum metus bibendum quis. Mauris lacinia, massa eget auctor efficitur, turpis ipsum congue tellus, at ultrices arcu ante tincidunt tellus. Mauris iaculis accumsan elit, sodales efficitur velit tristique quis. 

Nunc quis massa a ligula ullamcorper dapibus. Suspendisse non turpis gravida, ultrices odio eget, maximus massa. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce ut velit eget eros posuere lobortis vitae a ipsum. Pellentesque laoreet aliquet nibh, et dignissim ipsum molestie gravida. Duis eu lacinia massa. Nunc eget arcu a nulla euismod molestie eget vel enim. Aliquam erat volutpat. Integer laoreet leo purus, vitae malesuada diam tempor vitae. 

Donec at massa et neque auctor congue. Quisque finibus eu mi quis viverra. Curabitur vel ligula sit amet libero faucibus ultrices sit amet sed libero. Fusce ultricies et dolor at porttitor. Morbi eu pretium leo, a porttitor ante. Etiam magna ligula, convallis a nisi vel, placerat varius diam. Proin feugiat nisi non turpis rhoncus, vitae egestas odio finibus. Nullam quis aliquet risus. Cras ultrices sed metus eget dignissim. Mauris rhoncus, augue at rhoncus congue, dolor leo euismod libero, ac gravida velit turpis non diam. Praesent vestibulum tellus ac turpis commodo tincidunt. Quisque hendrerit, orci at cursus semper, nisl arcu ultricies felis, at mollis libero metus aliquam dolor. In eget sem malesuada odio lobortis sagittis. 

Vivamus consectetur, enim vitae blandit tempor, dui velit hendrerit enim, non ornare mauris purus non eros. Donec aliquet varius mauris vitae porta. Etiam lobortis placerat lectus ut semper. Nam malesuada mollis dui, non blandit metus feugiat quis. Sed in ligula sed ligula volutpat vestibulum eget ac eros. Etiam pellentesque auctor nisl, vel scelerisque magna maximus bibendum. Pellentesque placerat diam faucibus mi accumsan elementum. Nunc sed dui diam. Suspendisse est dolor, pellentesque sed molestie in, rutrum rhoncus dui. Mauris velit lectus, vestibulum id quam eget, malesuada lacinia est. Etiam varius iaculis quam, sed scelerisque libero egestas id. Donec congue lacus ligula. Curabitur ornare, lorem sed ultrices sagittis, nibh metus laoreet risus, id vestibulum sapien neque in leo. 

Fusce rutrum neque eu viverra aliquam. Aliquam tristique feugiat mauris, dapibus consequat nisl faucibus id. Fusce vestibulum maximus mi, nec mollis lorem congue mollis. Quisque vitae euismod erat, suscipit molestie elit. Pellentesque euismod vitae magna eget semper. Vestibulum justo lacus, bibendum vel feugiat non, lacinia in nibh. Praesent nec aliquet magna, ut maximus diam. Aliquam cursus ultricies leo quis consequat. Nam nec leo mauris. Mauris lobortis nunc ex, vitae efficitur ligula facilisis eget. In varius non purus eget rhoncus.',1483351777),
 (5,1,1,'Lorem ipsum','lorem-ipsum','## Lorem

Lorem ipsum **dolor** sit amet, *consectetur* adipiscing elit. Ut nec enim erat. Integer malesuada tincidunt mauris, at bibendum leo. Pellentesque velit neque, mattis quis metus nec, tristique posuere odio. Pellentesque consectetur dui vulputate, placerat arcu sed, sollicitudin neque. Etiam porta urna vitae luctus fringilla. Nulla facilisi. Etiam id nisi metus. Sed volutpat euismod est sed aliquam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer porttitor tempor massa, pellentesque fringilla quam interdum et. Phasellus gravida sollicitudin quam, dignissim condimentum metus bibendum quis. Mauris lacinia, massa eget auctor efficitur, turpis ipsum congue tellus, at ultrices arcu ante tincidunt tellus. Mauris iaculis accumsan elit, sodales efficitur velit tristique quis. 

## Ipsum

Nunc quis massa a ligula ullamcorper dapibus. Suspendisse non turpis gravida, ultrices odio eget, maximus massa. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce ut velit eget eros posuere lobortis vitae a ipsum. Pellentesque laoreet aliquet nibh, et dignissim ipsum molestie gravida. Duis eu lacinia massa. Nunc eget arcu a nulla euismod molestie eget vel enim. Aliquam erat volutpat. Integer laoreet leo purus, vitae malesuada diam tempor vitae. 

Donec at massa et neque auctor congue. Quisque finibus eu mi quis viverra. Curabitur vel ligula sit amet libero faucibus ultrices sit amet sed libero. Fusce ultricies et dolor at porttitor. Morbi eu pretium leo, a porttitor ante. Etiam magna ligula, convallis a nisi vel, placerat varius diam. Proin feugiat nisi non turpis rhoncus, vitae egestas odio finibus. Nullam quis aliquet risus. Cras ultrices sed metus eget dignissim. Mauris rhoncus, augue at rhoncus congue, dolor leo euismod libero, ac gravida velit turpis non diam. Praesent vestibulum tellus ac turpis commodo tincidunt. Quisque hendrerit, orci at cursus semper, nisl arcu ultricies felis, at mollis libero metus aliquam dolor. In eget sem malesuada odio lobortis sagittis. 

Vivamus consectetur, enim vitae blandit tempor, dui velit hendrerit enim, non ornare mauris purus non eros. Donec aliquet varius mauris vitae porta. Etiam lobortis placerat lectus ut semper. Nam malesuada mollis dui, non blandit metus feugiat quis. Sed in ligula sed ligula volutpat vestibulum eget ac eros. Etiam pellentesque auctor nisl, vel scelerisque magna maximus bibendum. Pellentesque placerat diam faucibus mi accumsan elementum. Nunc sed dui diam. Suspendisse est dolor, pellentesque sed molestie in, rutrum rhoncus dui. Mauris velit lectus, vestibulum id quam eget, malesuada lacinia est. Etiam varius iaculis quam, sed scelerisque libero egestas id. Donec congue lacus ligula. Curabitur ornare, lorem sed ultrices sagittis, nibh metus laoreet risus, id vestibulum sapien neque in leo. 

Fusce rutrum neque eu viverra aliquam. Aliquam tristique feugiat mauris, dapibus consequat nisl faucibus id. Fusce vestibulum maximus mi, nec mollis lorem congue mollis. Quisque vitae euismod erat, suscipit molestie elit. Pellentesque euismod vitae magna eget semper. Vestibulum justo lacus, bibendum vel feugiat non, lacinia in nibh. Praesent nec aliquet magna, ut maximus diam. Aliquam cursus ultricies leo quis consequat. Nam nec leo mauris. Mauris lobortis nunc ex, vitae efficitur ligula facilisis eget. In varius non purus eget rhoncus.',1483369301),
 (7,2,1,'Hello World','hello-world','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nec enim erat. Integer malesuada tincidunt mauris, at bibendum leo. Pellentesque velit neque, mattis quis metus nec, tristique posuere odio. Pellentesque consectetur dui vulputate, placerat arcu sed, sollicitudin neque. Etiam porta urna vitae luctus fringilla. Nulla facilisi. Etiam id nisi metus. Sed volutpat euismod est sed aliquam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer porttitor tempor massa, pellentesque fringilla quam interdum et. Phasellus gravida sollicitudin quam, dignissim condimentum metus bibendum quis. Mauris lacinia, massa eget auctor efficitur, turpis ipsum congue tellus, at ultrices arcu ante tincidunt tellus. Mauris iaculis accumsan elit, sodales efficitur velit tristique quis. 

Nunc quis massa a ligula ullamcorper dapibus. Suspendisse non turpis gravida, ultrices odio eget, maximus massa. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce ut velit eget eros posuere lobortis vitae a ipsum. Pellentesque laoreet aliquet nibh, et dignissim ipsum molestie gravida. Duis eu lacinia massa. Nunc eget arcu a nulla euismod molestie eget vel enim. Aliquam erat volutpat. Integer laoreet leo purus, vitae malesuada diam tempor vitae. 

Donec at massa et neque auctor congue. Quisque finibus eu mi quis viverra. Curabitur vel ligula sit amet libero faucibus ultrices sit amet sed libero. Fusce ultricies et dolor at porttitor. Morbi eu pretium leo, a porttitor ante. Etiam magna ligula, convallis a nisi vel, placerat varius diam. Proin feugiat nisi non turpis rhoncus, vitae egestas odio finibus. Nullam quis aliquet risus. Cras ultrices sed metus eget dignissim. Mauris rhoncus, augue at rhoncus congue, dolor leo euismod libero, ac gravida velit turpis non diam. Praesent vestibulum tellus ac turpis commodo tincidunt. Quisque hendrerit, orci at cursus semper, nisl arcu ultricies felis, at mollis libero metus aliquam dolor. In eget sem malesuada odio lobortis sagittis. 

Vivamus consectetur, enim vitae blandit tempor, dui velit hendrerit enim, non ornare mauris purus non eros. Donec aliquet varius mauris vitae porta. Etiam lobortis placerat lectus ut semper. Nam malesuada mollis dui, non blandit metus feugiat quis. Sed in ligula sed ligula volutpat vestibulum eget ac eros. Etiam pellentesque auctor nisl, vel scelerisque magna maximus bibendum. Pellentesque placerat diam faucibus mi accumsan elementum. Nunc sed dui diam. Suspendisse est dolor, pellentesque sed molestie in, rutrum rhoncus dui. Mauris velit lectus, vestibulum id quam eget, malesuada lacinia est. Etiam varius iaculis quam, sed scelerisque libero egestas id. Donec congue lacus ligula. Curabitur ornare, lorem sed ultrices sagittis, nibh metus laoreet risus, id vestibulum sapien neque in leo. 

Fusce rutrum neque eu viverra aliquam. Aliquam tristique feugiat mauris, dapibus consequat nisl faucibus id. Fusce vestibulum maximus mi, nec mollis lorem congue mollis. Quisque vitae euismod erat, suscipit molestie elit. Pellentesque euismod vitae magna eget semper. Vestibulum justo lacus, bibendum vel feugiat non, lacinia in nibh. Praesent nec aliquet magna, ut maximus diam. Aliquam cursus ultricies leo quis consequat. Nam nec leo mauris. Mauris lobortis nunc ex, vitae efficitur ligula facilisis eget. In varius non purus eget rhoncus.',1483351763);
CREATE TABLE `comments` (
	`id`	INTEGER,
	`post_id`	INTEGER NOT NULL,
	`username`	TEXT NOT NULL,
	`mail`	TEXT NOT NULL,
	`content`	TEXT NOT NULL,
	`created`	INTEGER NOT NULL,
	PRIMARY KEY(id)
);
INSERT INTO `comments` (id,post_id,username,mail,content,created) VALUES (1,7,'test','test@test.com','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laudantium voluptatibus quae doloribus dolorem earum dicta quasi. Fugit, eligendi, voluptatibus corporis deleniti perferendis accusantium totam harum dolor ab veniam laudantium!',0),
 (2,16,'az','az','az',1483366312),
 (3,16,'az','az','az',1483366356),
 (4,16,'az','az','az',1483366385),
 (5,16,'az','az','az',1483366419),
 (6,16,'az','az','az',1483366433),
 (7,16,'az','az@test.fr','az',1483367457);
CREATE TABLE "categories" (
	`id`	INTEGER,
	`name`	TEXT UNIQUE,
	`slug`	TEXT,
	PRIMARY KEY(id)
);
INSERT INTO `categories` (id,name,slug) VALUES (1,'Hello','hello'),
 (7,'World','world');
COMMIT;
