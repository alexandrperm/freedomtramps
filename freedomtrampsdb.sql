-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 19 2014 г., 17:35
-- Версия сервера: 5.5.38-log
-- Версия PHP: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `freedomtrampsdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ft_cat`
--

CREATE TABLE IF NOT EXISTS `ft_cat` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id категории',
  `name` varchar(255) NOT NULL COMMENT 'имя категории',
  `ur` varchar(255) NOT NULL COMMENT 'url категории',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ft_comments`
--

CREATE TABLE IF NOT EXISTS `ft_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id комментария',
  `post_id` int(11) NOT NULL COMMENT 'id поста, связанного с комментарием',
  `user` varchar(255) NOT NULL COMMENT 'имя пользователя, отправившего комментарий',
  `user_status` int(11) NOT NULL COMMENT 'статус пользователя (активный, забанен итд)',
  `text` text NOT NULL COMMENT 'текст комментария',
  `date_c` datetime NOT NULL COMMENT 'дата комментирования',
  `email` varchar(255) NOT NULL COMMENT 'email автора коммента',
  `site` varchar(255) NOT NULL COMMENT 'сайт автора коммента',
  `rating` int(11) NOT NULL COMMENT 'рейтинг комментария	',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='комментарии' AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `ft_comments`
--

INSERT INTO `ft_comments` (`id`, `post_id`, `user`, `user_status`, `text`, `date_c`, `email`, `site`, `rating`) VALUES
(1, 1, '1', 1, '1', '0000-00-00 00:00:00', '', '', 0),
(2, 2, 'ssdgfgdfgdf', 0, 'fdgdfgdfgdfg', '0000-00-00 00:00:00', 'dfgdf@chfgh.dg', '', 0),
(3, 2, 'вапвап', 0, 'sdfgdsgfdg', '0000-00-00 00:00:00', 'dfgdf@chfgh.dg', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_feedback`
--

CREATE TABLE IF NOT EXISTS `ft_feedback` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id сообщения ',
  `user` varchar(255) NOT NULL COMMENT 'имя отправителя	',
  `subj` varchar(255) NOT NULL COMMENT 'тема сообщения',
  `date_c` datetime NOT NULL COMMENT 'дата отправки',
  `email` varchar(255) NOT NULL COMMENT 'почта',
  `site` varchar(255) NOT NULL COMMENT 'сайт',
  `text` text NOT NULL COMMENT 'текст',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='сообщения, отправленные через форму обратной связи' AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `ft_feedback`
--

INSERT INTO `ft_feedback` (`id`, `user`, `subj`, `date_c`, `email`, `site`, `text`) VALUES
(1, 'Введите ник*', 'Тема*', '0000-00-00 00:00:00', 'E-mail*', 'Сайт*', 'Введите текст*');

-- --------------------------------------------------------

--
-- Структура таблицы `ft_posts`
--

CREATE TABLE IF NOT EXISTS `ft_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id поста',
  `text` text NOT NULL COMMENT 'текст поста',
  `category` int(11) NOT NULL COMMENT 'id категории',
  `user` varchar(255) NOT NULL COMMENT 'пользователь, создавший пост',
  `title` varchar(255) NOT NULL COMMENT 'заголовок поста',
  `date_c` datetime NOT NULL COMMENT 'дата создания',
  `date_e` datetime NOT NULL COMMENT 'дата последнего изменения ',
  `date_p` datetime NOT NULL COMMENT 'дата публикации',
  `post_status` int(11) NOT NULL COMMENT 'статус поста',
  `is_commenting` int(11) NOT NULL COMMENT ' разрешено ли комментирование',
  `comment_num` int(11) NOT NULL COMMENT 'число комментариев',
  `view_num` int(11) NOT NULL COMMENT 'число просмотров',
  `post_url` varchar(255) NOT NULL COMMENT 'url поста',
  `meta_d` varchar(255) NOT NULL COMMENT 'meta описание',
  `meta_k` varchar(255) NOT NULL COMMENT 'мета - ключевые слова',
  `rating` int(11) NOT NULL COMMENT 'рейтинг поста',
  `ontop` int(11) NOT NULL COMMENT 'показывать на главной',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='посты' AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `ft_posts`
--

INSERT INTO `ft_posts` (`id`, `text`, `category`, `user`, `title`, `date_c`, `date_e`, `date_p`, `post_status`, `is_commenting`, `comment_num`, `view_num`, `post_url`, `meta_d`, `meta_k`, `rating`, `ontop`) VALUES
(1, '<p>Хотел дописать свою CMS но увы дело это долгое [cut]</p>\n<p>по причине того, что постоянно придумываю что-то еще, и внедряю все новые элементы.. Боюсь что мое, так сказать, &laquo;дописывание&raquo; может никогда не закончится. Эта небольшая статья будет содержать цель, эдакий план, моего (и Вашего) проекта. Написание статей на блоге помогает мне разобраться в написанном коде, и улучшать его. Тем самым этот цикл статей мне поможет точно, возможно он и поможет Вам, ведь эти статьи можно расценивать как <strong>уроки php</strong>. Писать будем скрипт блога, то есть нарекаю этот цикл именем <strong>&laquo;создать блог с нуля&raquo;</strong>!</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>Во время создания скрипта блога мы будем пытаться не смешивать php код с html кодом. Я переписал код своего блога именно так, и скажу с уверенностью, что править такой сайт намного легче. Особенно если нужно сменить дизайн не трогая код.</p>\n<p>В цикл войдут такие разделы как базовые навыки html, несколько уроков php, и само собой много много практики <img title="Улыбаюсь" src="http://rio-shaman.ru/img/smile/smiley-smile.gif" alt="Улыбаюсь" border="0" /></p>\n<p><em>Не советую пропускать ни одной из статей, начните с верстки, после почитайте материал из части <strong>&laquo;уроки php&raquo;</strong>, далее изучите базовый функционал блога (Часть III и IV). Так Вы сможете понять как устроен сам движок. Уже под конец приступайте к самому сложному, это к улучшением. Приятного Вам изучения <img title="Улыбаюсь" src="http://rio-shaman.ru/img/smile/smiley-smile.gif" alt="Улыбаюсь" border="0" /><br /></em></p>\n<p>Вот ссылки на уже написанные статьи:</p>', 0, 'я', 'Это название статьи', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, '', 'Описание статьи1', 'Ключевые слова1', 0, 0),
(2, '<p>Введите текст*</p>', 0, 'Автор*', 'Название статьи*', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, '', '1', '2', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `ft_users`
--

CREATE TABLE IF NOT EXISTS `ft_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'идентификатор',
  `login` varchar(255) NOT NULL COMMENT 'логин',
  `pass` varchar(255) NOT NULL COMMENT 'md5 хеш пароля',
  `date_reg` datetime NOT NULL COMMENT 'дата регистрации',
  `date_act` datetime NOT NULL COMMENT 'дата последней активности',
  `status` int(11) NOT NULL COMMENT 'статус(0- активен, 1 - заблокирован)',
  `group` int(11) NOT NULL COMMENT 'id группы, в которой находится пользователь, для разграничения доступа',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='пользователи' AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `ft_users`
--

INSERT INTO `ft_users` (`id`, `login`, `pass`, `date_reg`, `date_act`, `status`, `group`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
