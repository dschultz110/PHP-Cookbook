-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2019 at 07:41 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: cookbook
--

-- --------------------------------------------------------

--
-- Table structure for table images
--

CREATE TABLE images (
  imageId int(11) NOT NULL,
  imageName varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  recipeId int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table images
--

INSERT INTO images (imageId, imageName, recipeId) VALUES
(9, 'baconCarbonara_9.jpg', 35),
(10, 'cheeseAndPasta_10.jpg', 43);

-- --------------------------------------------------------

--
-- Table structure for table mealTypes
--

CREATE TABLE mealTypes (
  mealTypeId int(11) NOT NULL,
  mealTypeName varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table mealTypes
--

INSERT INTO mealTypes (mealTypeId, mealTypeName) VALUES
(1, 'breakfast'),
(2, 'lunch'),
(3, 'dinner'),
(4, 'dessert'),
(5, 'appetizer'),
(6, 'beverage');

-- --------------------------------------------------------

--
-- Table structure for table recipes
--

CREATE TABLE recipes (
  recipeId int(11) NOT NULL,
  userId int(11) NOT NULL,
  recipeName varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  tags varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  prepTime varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  cookTime varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  mealType int(11) NOT NULL,
  ingredients varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  instructions varchar(2000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table recipes
--

INSERT INTO recipes (recipeId, userId, recipeName, tags, prepTime, cookTime, mealType, ingredients, instructions) VALUES
(1, 1, 'Orange Sherbet Punch', 'easy, fast, party', '5 minutes', 'none', 6, '&lt;ul&gt;\r\n&lt;li&gt;1 frozen concentrated orange juice - thawed&lt;/li&gt;\r\n&lt;li&gt;1 frozen concentrated pink lemonade - thawed&lt;/li&gt;\r\n&lt;li&gt;2 cans of water&lt;/li&gt;\r\n&lt;li&gt;1 large can unsweetened pineapple juice&lt;/li&gt;\r\n&lt;li&gt;2 liters ginger ale&lt;/li&gt;\r\n&lt;li&gt;1 quart orange sherbet - thawed&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Mix everything together&lt;/li&gt;\r\n&lt;li&gt;Serve from punch bowl immediately&lt;/li&gt;\r\n&lt;/ol&gt;'),
(2, 1, 'Eggnog', 'holiday, easy', '5 minutes', '0 minutes', 6, '&lt;ul&gt;\r\n&lt;li&gt;2 eggs - well beaten&lt;/li&gt;\r\n&lt;li&gt;2 cups milk&lt;/li&gt;\r\n&lt;li&gt;4 tbsp. sugar&lt;/li&gt;\r\n&lt;li&gt;1/2 tsp. vanilla&lt;/li&gt;\r\n&lt;li&gt;nutmeg&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Beat eggs and sugar together. Add milk and vanilla.&lt;/li&gt;\r\n&lt;li&gt;Beat until well mixed.&lt;/li&gt;\r\n&lt;li&gt;Pour into glasses and sprinkle with nutmeg.&lt;/li&gt;\r\n&lt;/ol&gt;'),
(3, 1, 'Irish Cream', 'alcohol, cocktail, ', '4 hours', 'none', 6, '&lt;ul&gt;\r\n&lt;li&gt;1 can condensed milk&lt;/li&gt;\r\n&lt;li&gt;1 can&nbsp; evaporated milk&lt;/li&gt;\r\n&lt;li&gt;3 eggs&lt;/li&gt;\r\n&lt;li&gt;1 tsp. vanilla&lt;/li&gt;\r\n&lt;li&gt;1 1/2 cup rye whiskey&lt;/li&gt;\r\n&lt;li&gt;2 tbsp. chocolate syrup&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Blend first 4 ingredients well&lt;/li&gt;\r\n&lt;li&gt;Add the whiskey and chocolate syrup and mix well&lt;/li&gt;\r\n&lt;li&gt;Let set in fridge at least 4 hours&lt;/li&gt;\r\n&lt;li&gt;Makes 26 oz&lt;/li&gt;\r\n&lt;/ol&gt;'),
(4, 1, 'Crab Dip', 'dip, crab, easy, ', '10 minutes', 'none', 5, '&lt;ul&gt;\r\n&lt;li&gt;5 oz. crab meat&lt;/li&gt;\r\n&lt;li&gt;1/2 cup mayonnaise&lt;/li&gt;\r\n&lt;li&gt;1 tsp. horse radish&lt;/li&gt;\r\n&lt;li&gt;8 oz. cream cheese - softened&lt;/li&gt;\r\n&lt;li&gt;1 tbsp. ketchup&lt;/li&gt;\r\n&lt;li&gt;1 tsp. lemon juice&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Blend all ingredients together except the crab with mixer until smooth&lt;/li&gt;\r\n&lt;li&gt;Flake crab, stir into mixture until well blended&lt;/li&gt;\r\n&lt;/ol&gt;'),
(5, 2, 'Tuna Cheese Ball', 'holiday, ', '2 hours', '0 minutes', 5, '&lt;ul&gt;\r\n&lt;li&gt;7 oz. canned tuna - well drained&lt;/li&gt;\r\n&lt;li&gt;4 oz. cream cheese - softened&lt;/li&gt;\r\n&lt;li&gt;1/4 cup butter - softened&lt;/li&gt;\r\n&lt;li&gt;1.2 cup diced onion&lt;/li&gt;\r\n&lt;li&gt;1 tsp. lemon juice&lt;/li&gt;\r\n&lt;li&gt;1/4 tsp. pepper&lt;/li&gt;\r\n&lt;li&gt;walnuts - finely chopped, for rolling, optional *&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Blend first six ingredients well&lt;/li&gt;\r\n&lt;li&gt;Place in a bowl and refrigerate until chilled&lt;/li&gt;\r\n&lt;li&gt;Divide into balls&lt;/li&gt;\r\n&lt;li&gt;Roll in chopped walnuts *&lt;/li&gt;\r\n&lt;li&gt;Wrap tightly in cling wrap until ready to use&lt;/li&gt;\r\n&lt;/ol&gt;'),
(6, 2, 'Holiday Cheese Ball', 'holiday, ', '4 hours', '0 minutes', 5, '&lt;ul&gt;\r\n&lt;li&gt;16 oz. cream cheese - softened&lt;/li&gt;\r\n&lt;li&gt;4 oz. marchino cherries - well drained and finely chopped&lt;/li&gt;\r\n&lt;li&gt;1/3 cup green pepper - diced&lt;/li&gt;\r\n&lt;li&gt;2 tbsp. dried minced onion&lt;/li&gt;\r\n&lt;li&gt;1 cup crushed pineapple - well drained&lt;/li&gt;\r\n&lt;li&gt;1/4 tsp. seasoning salt&lt;/li&gt;\r\n&lt;li&gt;3/4 cup finely chopped pecans&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Blend first six ingredients well&lt;/li&gt;\r\n&lt;li&gt;Divide and shape into balls&lt;/li&gt;\r\n&lt;li&gt;Refrigerate at least 4 hours or overnight&lt;/li&gt;\r\n&lt;li&gt;Before serving, roll balls in chopped pecans&lt;/li&gt;\r\n&lt;li&gt;Wrap tightly in saran wraps until ready to use&lt;/li&gt;\r\n&lt;/ol&gt;'),
(7, 1, 'Taco Salad', 'taco, easy', '5 minutes', '20 minutes', 5, '&lt;ul&gt;\r\n&lt;li&gt;1 lb. extra lean ground beef&lt;/li&gt;\r\n&lt;li&gt;1 bunch green onions - chopped&lt;/li&gt;\r\n&lt;li&gt;1 package taco seasoning mix&lt;/li&gt;\r\n&lt;li&gt;1 head lettuce - chopped&lt;/li&gt;\r\n&lt;li&gt;3 tomatoes&lt;/li&gt;\r\n&lt;li&gt;8 oz. grated cheddar cheese&lt;/li&gt;\r\n&lt;li&gt;8 oz. Catalina dressing&lt;/li&gt;\r\n&lt;li&gt;250 g. corn chips or crushed nacho chips&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Brown beef with 1/3 green onions and taco seasoning mix. Cool&lt;/li&gt;\r\n&lt;li&gt;Just before serving, toss remaining ingredients along with meat in a large salad bowl&lt;/li&gt;\r\n&lt;/ol&gt;'),
(8, 1, 'Fluffy Fruit Salad', 'fruit', '30 minutes', '5 hours', 4, '&lt;ul&gt;\r\n&lt;li&gt;2 (20 oz. each) cans crushed pineapple&lt;/li&gt;\r\n&lt;li&gt;2 cans (17 oz. each) fruit cocktail - drained&lt;/li&gt;\r\n&lt;li&gt;2 cans (11 oz. each) mandarin oranged - drained&lt;/li&gt;\r\n&lt;li&gt;2/3 cup sugar&lt;/li&gt;\r\n&lt;li&gt;2 tbsp. all purpose flour&lt;/li&gt;\r\n&lt;li&gt;2 eggs - lightly beaten&lt;/li&gt;\r\n&lt;li&gt;1/4 cup orange juice&lt;/li&gt;\r\n&lt;li&gt;3 tbsp. lemon juice&lt;/li&gt;\r\n&lt;li&gt;1 tbsp. vegetable oil&lt;/li&gt;\r\n&lt;li&gt;2 bananas - sliced&lt;/li&gt;\r\n&lt;li&gt;1 cup heavy cream - whipped&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Drain pineapple, reserve 1 cup juice in small saucepan. Set pineapple aside&lt;/li&gt;\r\n&lt;li&gt;Add sugar, flour, eggs, orange juice, lemon juice, and oil to the saucepan&lt;/li&gt;\r\n&lt;li&gt;In a salad bowl, combine pineapple, fruit cocktail, oranges, and banana&lt;/li&gt;\r\n&lt;li&gt;Fold in whipped cream and cooled sauce&lt;/li&gt;\r\n&lt;li&gt;Chill for 5 hours&lt;/li&gt;\r\n&lt;/ol&gt;\r\n&lt;p&gt;Makes 16 servings&lt;/p&gt;'),
(9, 1, 'Summertime Pasta Salad', 'salad, pasta, cold', '20 minutes', '0 minutes', 5, '&lt;p&gt;Pasta:&lt;/p&gt;\r\n&lt;ul&gt;\r\n&lt;li&gt;2 cups cooked macaroni or spiral pasta&lt;/li&gt;\r\n&lt;li&gt;2 tomatoes - cubed&lt;/li&gt;\r\n&lt;li&gt;1 green onion - chopped&lt;/li&gt;\r\n&lt;li&gt;1/2 green pepper - chopped&lt;/li&gt;\r\n&lt;li&gt;1/4 cup cucumber - chopped&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;p&gt;Dressing:&lt;/p&gt;\r\n&lt;ul&gt;\r\n&lt;li&gt;1/2 cup sugar&lt;/li&gt;\r\n&lt;li&gt;1/2 cup oil&lt;/li&gt;\r\n&lt;li&gt;1/3 cup ketchup&lt;/li&gt;\r\n&lt;li&gt;1/4 cup vinegar&lt;/li&gt;\r\n&lt;li&gt;1 tsp. salt&lt;/li&gt;\r\n&lt;li&gt;1 tsp. paprika&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Mix all the pasta ingredients together in a bowl and set aside.&lt;/li&gt;\r\n&lt;li&gt;For the dressing, combine ingredients in a small saucepan. Heat thoroughly&lt;/li&gt;\r\n&lt;li&gt;Remove from heat and cool.&lt;/li&gt;\r\n&lt;li&gt;Pour dressing over salad ingredients, marinate overnight, and serve cold&lt;/li&gt;\r\n&lt;/ol&gt;'),
(10, 2, 'Bacon Carbonara', 'sauce, bacon', '5 minutes', '20 minutes', 3, '&lt;ul&gt;\r\n&lt;li&gt;1 lb. bacon&lt;/li&gt;\r\n&lt;li&gt;2 lbs. fresh mushrooms&lt;/li&gt;\r\n&lt;li&gt;1 bunch green onions&lt;/li&gt;\r\n&lt;li&gt;1 can cream of mushroom soup&lt;/li&gt;\r\n&lt;li&gt;1 can cream of mushroom and onion soup&lt;/li&gt;\r\n&lt;li&gt;1 can milk&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Fry bacon until crispy. Break into pieces and set aside&lt;/li&gt;\r\n&lt;li&gt;Slice mushrooms and onions. Fry until mushrooms have finished shrinking and are tender&lt;/li&gt;\r\n&lt;li&gt;In medium sized pot, combine both soups and milk.&lt;/li&gt;\r\n&lt;li&gt;Stir in bacon, mushrooms, and onions. Warm until heated through&lt;/li&gt;\r\n&lt;li&gt;Serve over your favourite pasta&lt;/li&gt;\r\n&lt;/ol&gt;'),
(11, 2, 'Cheese and Pasta in a Pot', 'casserole, cheese, tomato', '10 minutes', '1 hour', 3, '&lt;ul&gt;\r\n&lt;li&gt;8 oz. large shell macaroni&lt;/li&gt;\r\n&lt;li&gt;2 lbs. ground beef&lt;/li&gt;\r\n&lt;li&gt;2 onions - chopped&lt;/li&gt;\r\n&lt;li&gt;1/4 tsp. garlic powder&lt;/li&gt;\r\n&lt;li&gt;14 oz. canned crushed tomatoes&lt;/li&gt;\r\n&lt;li&gt;14 oz. canned spaghetti sauce&lt;/li&gt;\r\n&lt;li&gt;10 oz. mushroom pieces and juice&lt;/li&gt;\r\n&lt;li&gt;2 cups sour cream&lt;/li&gt;\r\n&lt;li&gt;1/2 lb. cheddar cheese&lt;/li&gt;\r\n&lt;li&gt;1/2 lb. mozzarella cheese&lt;/li&gt;\r\n&lt;/ul&gt;', '&lt;ol&gt;\r\n&lt;li&gt;Cook macaroni, rinse, drain, and set aside.&lt;/li&gt;\r\n&lt;li&gt;Brown beef and drain.&lt;/li&gt;\r\n&lt;li&gt;Add onions, garlic powder, tomatoes, speghetti sauce, and mushrooms.&lt;/li&gt;\r\n&lt;li&gt;Bring to boil and simmer 20 minutes, stirring occassionally. Remove from heat.&lt;/li&gt;\r\n&lt;li&gt;In large casserole dish, pour 1/2 the macaroni on the bottom, then pour 1/2 the meat sauce over top. Spread with 1/2 sour cream&lt;/li&gt;\r\n&lt;li&gt;Add 1/2 the shredded cheeses and cover with remaining macaroni, meatsauce, sour cream, and cheese.&lt;/li&gt;\r\n&lt;li&gt;Cover and bake at 350 F for 45 minutes&lt;/li&gt;\r\n&lt;li&gt;Remove cover and bake until cheese is melted.&lt;/li&gt;\r\n&lt;/ol&gt;\r\n&lt;p&gt;Makes 12 servings&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table recipeTags
--

CREATE TABLE recipeTags (
  tagId int(11) NOT NULL,
  recipeId int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table recipeTags
--

INSERT INTO recipeTags (tagId, recipeId) VALUES
(61, 26),
(61, 27),
(61, 29),
(61, 32),
(61, 37),
(62, 26),
(62, 37),
(63, 26),
(64, 27),
(64, 30),
(64, 31),
(66, 28),
(67, 28),
(69, 29),
(70, 29),
(76, 32),
(78, 33),
(79, 34),
(80, 34),
(81, 34),
(82, 35),
(83, 35),
(90, 37),
(94, 38),
(94, 39),
(94, 40),
(97, 41),
(97, 42),
(99, 43),
(100, 43),
(101, 43),
(102, 44),
(103, 44);

-- --------------------------------------------------------

--
-- Table structure for table tags
--

CREATE TABLE tags (
  tagId int(11) NOT NULL,
  tagName varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table tags
--

INSERT INTO tags (tagId, tagName) VALUES
(1, 'alcohol'),
(2, 'bacon'),
(3, 'casserole'),
(4, 'cheese'),
(5, 'cocktail'),
(6, 'cold'),
(7, 'crab'),
(8, 'delicous'),
(9, 'dip'),
(10, 'dairy'),
(11, 'easy'),
(12, 'easy peasy'),
(13, 'eggs'),
(14, 'fast'),
(15, 'fruit'),
(16, 'holiday'),
(17, 'party'),
(18, 'pasta'),
(19, 'salad'),
(20, 'taco'),
(22, 'tomato');

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  userId int(11) NOT NULL,
  firstName varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  lastName varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  email varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  password varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  permissionLevel int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table users
--

INSERT INTO users (userId, firstName, lastName, email, password, permissionLevel) VALUES
(1, 'Ash', 'Ketchum', 'user3@email.com', '$2y$10$Bye23eqeAw2hjAovCUHfCeX2W5YTmDr4tbiDmqPGq4Onv9pY2Hqw.', 1),
(2, 'Professor', 'Oak', 'admin1@email.com', '$2y$10$e5L600UuUaOG8xT.Zkr6SOilen1WHZbOnsCSbY3iCpqemT6yKRgfK', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table images
--
ALTER TABLE images
  ADD PRIMARY KEY (imageId);

--
-- Indexes for table mealTypes
--
ALTER TABLE mealTypes
  ADD PRIMARY KEY (mealTypeId);

--
-- Indexes for table recipes
--
ALTER TABLE recipes
  ADD PRIMARY KEY (recipeId);

--
-- Indexes for table recipeTags
--
ALTER TABLE recipeTags
  ADD PRIMARY KEY (tagId,recipeId);

--
-- Indexes for table tags
--
ALTER TABLE tags
  ADD PRIMARY KEY (tagId),
  ADD UNIQUE KEY u_tagName (tagName);

--
-- Indexes for table users
--
ALTER TABLE users
  ADD PRIMARY KEY (userId);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table images
--
ALTER TABLE images
  MODIFY imageId int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table mealTypes
--
ALTER TABLE mealTypes
  MODIFY mealTypeId int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table recipes
--
ALTER TABLE recipes
  MODIFY recipeId int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table tags
--
ALTER TABLE tags
  MODIFY tagId int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table users
--
ALTER TABLE users
  MODIFY userId int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
