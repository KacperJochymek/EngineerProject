DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','doctor') DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` VALUES ('8','adam','adam@wp.pl','$2y$10$WOhaE7sknCzMaYUesN6SvuOqjVpHJc8IdQKfSslygiSNrzrZR3/iG','doctor');
INSERT INTO `users` VALUES ('10','admin','admin@wp.pl','$2y$10$5yt5i9GyXon9jjhCFI5iIOQSh9bWbeOOZQuVK45zjjYYi/iDzajGu','admin');
INSERT INTO `users` VALUES ('18','jurek','jurek@wp.pl','$2y$10$I3BahRy4qUV34I4R4p6MMO6pU8m.Sey8Kb3JgwaU9MI2uxnZnfIvy','user');
INSERT INTO `users` VALUES ('20','Yohm1','k.joch19@wp.pl','$2y$10$Ximqu15TxFzSPyJXS4jJUOO.Jzohnnh/JVWndOvLQ.qhO62Cx6tuS','user');

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE `doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lekarza` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `imienazwisko` varchar(255) NOT NULL,
  `profesja` varchar(255) NOT NULL,
  `obrazek` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `doctors` VALUES ('1','1','lek. med.','Anita Wolska','Podolog','lekarz-w.png');
INSERT INTO `doctors` VALUES ('2','2','lek.','Dominika Domagała','Onkolog','kobieta.png');

DROP TABLE IF EXISTS `pacjenci`;
CREATE TABLE `pacjenci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pacjenta` varchar(255) NOT NULL,
  `wiek` int(11) NOT NULL,
  `pesel` int(20) NOT NULL,
  `miasto` varchar(255) NOT NULL,
  `województwo` varchar(255) NOT NULL,
  `adres_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pacjenci` VALUES ('11','Bartosz Okoń','20','921390','Rzeszów','Podkarpackie','');
INSERT INTO `pacjenci` VALUES ('12','Bartek Arbuzik','9','9031209','Jaworzno','Śląskie','');
INSERT INTO `pacjenci` VALUES ('16','Kacper Jakubek','21','9032131','Jaworzno','Śląskie','');
INSERT INTO `pacjenci` VALUES ('17','Jakub Grodzki','29','743192019','Katowice','Śląskie','');
INSERT INTO `pacjenci` VALUES ('47','Kacper Mazurek','25','1222202196','Katowice','Śląskie','');
INSERT INTO `pacjenci` VALUES ('48','Kacper Larysz','23','1222299191','Katowice','Śląskie','');
INSERT INTO `pacjenci` VALUES ('68','Jakub Bronks','22','2147483647','Katowice','Śląskie','k.joch19@wp.pl');
INSERT INTO `pacjenci` VALUES ('74','Kacper Jach','22','1222202191','Katowice','Śląskie','k.joch19@wp.pl');
INSERT INTO `pacjenci` VALUES ('120','Łukasz Demon','33','2147483647','Toruń','Kujawsko-pomorskie','k.joch19@wp.pl');
INSERT INTO `pacjenci` VALUES ('122','Kacper ododod','22','1222542191','Łódź','Łódzkie','k.joch19@wp.pl');
INSERT INTO `pacjenci` VALUES ('123','Wiktoria Wrona','26','2147483647','Kraków','Małopolskie','k.joch19@wp.pl');

DROP TABLE IF EXISTS `wizyty`;
CREATE TABLE `wizyty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_wizyty` date NOT NULL,
  `available_hour` time NOT NULL,
  `doctor_id` varchar(255) NOT NULL,
  `status_wizyty` enum('dostepna','zarezerwowana','anulowana') NOT NULL DEFAULT 'dostepna',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `wizyty` VALUES ('4','2023-10-17','09:30:00','1','dostepna');
INSERT INTO `wizyty` VALUES ('6','2023-10-17','11:00:00','2','dostepna');
INSERT INTO `wizyty` VALUES ('8','2023-10-18','10:00:00','1','dostepna');
INSERT INTO `wizyty` VALUES ('9','2023-10-19','10:00:00','2','dostepna');
INSERT INTO `wizyty` VALUES ('15','2023-11-17','10:30:00','1','dostepna');
INSERT INTO `wizyty` VALUES ('22','2024-01-11','10:00:00','1','dostepna');
INSERT INTO `wizyty` VALUES ('23','2024-01-13','16:00:00','Anita Wolska','zarezerwowana');
INSERT INTO `wizyty` VALUES ('24','2024-01-10','10:30:00','Anita Wolska','zarezerwowana');

DROP TABLE IF EXISTS `cennik`;
CREATE TABLE `cennik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(255) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cennik` VALUES ('2','Wizyta kontrolna','149.99');
INSERT INTO `cennik` VALUES ('3','Konsultacja tel.','99.99');
INSERT INTO `cennik` VALUES ('4','Zestaw 2 badań','299.99');
INSERT INTO `cennik` VALUES ('5','Zestaw 10 badań','999.99');

DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tekst` text NOT NULL,
  `obrazek` varchar(255) DEFAULT NULL,
  `dat` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `blog` VALUES ('8','Przychodnie i lekarze pełnią kluczową rolę w opiece zdrowotnej, a korzystanie z nich jest niezwykle ważne dla naszego dobra. Nie tylko przez wieki, ale także w erze elektronicznego składu, pozostają istotnie niezmienione. Jednak teraz, dzięki naszej innowacyjnej aplikacji do umawiania wizyt u lekarza, możesz jeszcze skuteczniej zarządzać swoim zdrowiem. Nasza aplikacja zmienia sposób, w jaki ludzie korzystają z usług medycznych.\r\n\r\nDzięki niej możesz łatwo i wygodnie umawiać wizyty u lekarza bez konieczności długiego oczekiwania w kolejce czy dzwonienia do przychodni. To nowoczesne podejście do opieki zdrowotnej, które oszczędza Twój czas i ułatwia dostęp do lekarza. Przychodnie to miejsca, gdzie pacjenci otrzymują wszechstronną opiekę zdrowotną od wykwalifikowanych lekarzy i personelu medycznego.\r\n\r\nWizyty u lekarza stanowią nieodłączny element dbania o zdrowie i zapobiegania chorobom. Nasza aplikacja pozwala Ci skorzystać z tych usług w bardziej efektywny sposób. Dzięki niej możesz znaleźić odpowiedniego lekarza, dowiedzieć się o dostępnych terminach i umówić się na wizytę w zaledwie kilka kliknięć. Lekarze, posiadając wiedzę i doświadczenie, są w stanie diagnozować schorzenia, prowadzić leczenie i udzielać cennych porad pacjentom.\r\n\r\nDzięki naszej aplikacji możesz szybko skonsultować się z lekarzem, otrzymać niezbędne porady i rozpocząć leczenie, kiedy tego potrzebujesz. To narzędzie, które pomaga Ci dbać o swoje zdrowie w sposób nowoczesny i wygodny. Współczesna medycyna wykorzystuje zaawansowane technologie, aby zapewnić pacjentom najwyższą jakość opieki.\r\n\r\nNasza aplikacja do umawiania wizyt u lekarza to część tego postępu technologicznego, dzięki której możesz szybciej i łatwiej korzystać z usług medycznych. Niezależnie od postępu technologicznego, relacja między pacjentem a lekarzem pozostaje kluczowym elementem procesu leczenia, a nasza aplikacja pomaga ją umożliwić w jeszcze bardziej komfortowy sposób. Przychodnie i lekarze odgrywają niezastąpioną rolę w dbaniu o nasze zdrowie i dobrostan, a nasza aplikacja sprawia, że ta opieka jest bardziej dostępna i wygodna niż kiedykolwiek wcześniej.','pomysl.jpg','2023-10-05');
INSERT INTO `blog` VALUES ('9','Nowa technologiczna rewolucja w farmaceutycznym świecie niesie ze sobą przełomowe odkrycia. Zaawansowane narzędzia analizy danych i technologie biomedyczne umożliwiają personalizację terapii. Dzięki badaniom genetycznym, pacjenci mogą otrzymać leki dostosowane do ich indywidualnych potrzeb. To krok w kierunku medycyny precyzyjnej, która zwiększa skuteczność leczenia i minimalizuje skutki uboczne.\r\n\r\nInnowacje w dziedzinie nanotechnologii umożliwiają tworzenie leków o bardziej zaawansowanej strukturze, co może poprawić ich działanie. Ponadto, rozwijające się technologie produkcji biologicznej pozwalają na bardziej efektywną i zrównoważoną produkcję leków biotechnologicznych.\r\n\r\nWreszcie, rosnąca rola sztucznej inteligencji w farmacji przyspiesza proces odkrywania nowych związków chemicznych i optymalizację procesów badawczych. To wszystko przyczynia się do dynamicznego rozwoju farmaceutycznego przemysłu, który ma na celu poprawę zdrowia i jakości życia pacjentów.','techstack.png','2023-10-15');
INSERT INTO `blog` VALUES ('10','W branży farmaceutycznej pojawił się przełomowy nowy lek, który przynosi nadzieję na skuteczne leczenie dotkliwych schorzeń. Ten innowacyjny produkt jest wynikiem długotrwałych badań i zaawansowanej technologii.\r\n\r\nNowy lek, nazwijmy go \"InnoMed\", został stworzony w odpowiedzi na pilne potrzeby pacjentów cierpiących na choroby, które dotychczas były trudne do kontrolowania. InnoMed działa na zasadzie innowacyjnego mechanizmu, który atakuje korzenie problemu, minimalizując jednocześnie skutki uboczne.\r\n\r\nJednym z najważniejszych aspektów tego leku jest jego bezpieczeństwo i skuteczność. Przeszedł on rygorystyczne testy kliniczne, które potwierdziły jego zdolność do skutecznego łagodzenia objawów i poprawy jakości życia pacjentów. W rezultacie, pacjenci cierpiący na schorzenia, które wcześniej były trudne do leczenia, mogą teraz liczyć na lepsze perspektywy i nadzieję na zdrowie.\r\n\r\n\"InnoMed\" to również przykład współpracy międzynarodowej i zaangażowania naukowców, badaczy oraz farmaceutów, którzy dążą do tworzenia leków o rewolucyjnym potencjale. Wprowadzenie tego nowego leku na rynek stanowi ważny krok w kierunku poprawy opieki zdrowotnej i leczenia chorób, które wcześniej stanowiły wyzwanie.\r\n\r\nNie można przecenić znaczenia takich innowacyjnych rozwiązań w branży farmaceutycznej, ponieważ przynoszą nadzieję na zdrowie i polepszenie jakości życia wielu pacjentów. Wprowadzenie \"InnoMed\" to kolejny kamień milowy w dziedzinie medycyny i farmacji, który może zmienić życie wielu ludzi na lepsze.','pills.png','2023-10-28');

DROP TABLE IF EXISTS `dostepnosc`;
CREATE TABLE `dostepnosc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_wizyty` int(11) DEFAULT NULL,
  `id_pacjenta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_wizyty` (`id_wizyty`),
  KEY `id_pacjenta` (`id_pacjenta`),
  CONSTRAINT `dostepnosc_ibfk_1` FOREIGN KEY (`id_wizyty`) REFERENCES `wizyty` (`id`),
  CONSTRAINT `dostepnosc_ibfk_2` FOREIGN KEY (`id_pacjenta`) REFERENCES `pacjenci` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO dostepnosc VALUES ('54','23','74');
INSERT INTO dostepnosc VALUES ('55','24','74');

