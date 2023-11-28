-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2023 at 07:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final-project-2`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_table`
--

CREATE TABLE `login_table` (
  `user_name` varchar(50) NOT NULL,
  `Email` text NOT NULL,
  `pass_word` text NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_table`
--

INSERT INTO `login_table` (`user_name`, `Email`, `pass_word`, `user_type`) VALUES
('admin', 'admin@gmail.com', 'admin123', 3),
('ajohnson123', 'ajohnson123@gmail.com', 'ajohnson123', 1),
('athompson123', 'athompson123@gmail.com', 'athompson123', 1),
('athompson_nurse', 'athompson_nurse@gmail.com', 'athompson_nurse', 2),
('bjohnson_nurse', 'bjohnson_nurse@gmail.com', 'bjohnson_nurse', 2),
('bthagoat', 'bthagoat@gmail.com', 'bthagoat', 1),
('candry1', 'charlotteandry123@gmail.com', 'candry1', 1),
('candry2_nurse', 'candry2_nurse@gmail.com', 'candry2_nurse', 2),
('candry_nurse', 'candry_nurse@gmail.com', 'candry_nurse', 2),
('cthagoat', 'cthagoat@gmail.com', 'cthagoat', 1),
('danderson123', 'danderson123@gmail.com', 'last_time', 1),
('danderson_nurse', 'danderson_nurse@gmail.com', 'danderson_nurse', 2),
('dthompson123', 'dthompson123@gmail.com', 'dthompson123', 1),
('dwilson_nurse', 'dwilson_nurse@gmail.com', 'dwilson_nurse', 2),
('jbrown123', 'jbrown123@gmail.com', 'jbrown123', 1),
('jbrown_nurse', 'jbrown_nurse@gmail.com', 'jbrown_nurse\n', 2),
('jdoe123', 'jdoe123@gmail.com', 'jdoe123', 1),
('jwilson123', 'jwilson123@gmail.com', 'jwilson123\n', 1),
('jwilson_nurse', 'jwilson_nurse@gmail.com', 'jwilson_nurse', 2),
('ka_nurse', 'ka_nurse@gmail.com', 'ka_nurse', 2),
('lsmith123', 'lsmith123@gmail.com', 'lsmith123', 1),
('lsmith_nurse', 'lsmith_nurse@gmail.com', 'lsmith_nurse', 2),
('msmith123', 'msmith123@gmail.com', 'msmith123', 1),
('msmith_nurse', 'msmith_nurse@gmail.com', 'msmith_nurse', 2),
('mward', '', 'test2244', 2),
('nnursee', 'nnursee@gmail.com', 'nnursee', 2),
('rwilson123', 'rwilson123@gmail.com', 'rwilson123', 1),
('test12', 'ssmith_nurse@gmail.com', 'test12', 2),
('woohoo', 'woohoo@gmail.com', 'woohoo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nurse`
--

CREATE TABLE `nurse` (
  `eid` tinyint(4) NOT NULL,
  `Fname` varchar(8) DEFAULT NULL,
  `MI` varchar(1) DEFAULT NULL,
  `Lname` varchar(8) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `phone_number` bigint(20) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL DEFAULT 'Chicago',
  `state` varchar(100) NOT NULL DEFAULT 'IL',
  `user_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurse`
--

INSERT INTO `nurse` (`eid`, `Fname`, `MI`, `Lname`, `age`, `phone_number`, `gender`, `street`, `city`, `state`, `user_name`) VALUES
(1, 'Sarah', 'L', 'Smith', 30, 1256267271, 0, '123 Sesame St', 'Chicago', 'IL', 'test12'),
(4, 'David', 'R', 'Wilson', 35, 1234567890, 1, '123 Sesame St', 'Chicago', 'IL', 'dwilson_nurse'),
(5, 'Mary', 'A', 'Smith', 42, 1261575914, 0, '123 Sesame St', 'Chicago', 'IL', 'msmith_nurse'),
(6, 'Jennifer', 'M', 'Brown', 36, 1260464813, 1, '123 Sesame St', 'Chicago', 'IL', 'jbrown_nurse'),
(7, 'Daniel', 'J', 'Anderson', 45, 1259353802, 0, '123 Sesame St', 'Chicago', 'IL', 'danderson_nurse'),
(8, 'Laura', 'K', 'Smith', 32, 1258243691, 1, '123 Sesame St', 'Chicago', 'IL', 'lsmith_nurse'),
(9, 'John', 'C', 'Wilson', 38, 1257142580, 0, '123 Sesame St', 'Chicago', 'IL', 'jwilson_nurse'),
(10, 'Alice', 'L', 'Thompson', 29, 1234567890, 1, '12 Some Pl.', 'Carlos Town', 'IDK', 'athompson_nurse'),
(11, 'Charlott', 'T', 'Andry', 13, 7738919231, 0, '123 Sesame St', 'Chicago', 'IL', 'candry_nurse'),
(12, 'Charlott', 'N', 'Andry', 22, 7738919231, 1, '123 Sesame St', 'Chicago', 'IL', 'candry2_nurse'),
(13, 'Kenan', 'P', 'A', 2, 7737377337, 1, '123 Sesame St', 'Chicago', 'IL', 'ka_nurse'),
(14, 'New', 'N', 'Urse', 33, 1234567890, 0, '123 Somthing St', 'Chicago', 'IL', 'nnursee'),
(15, 'Bob', 'E', 'Johnson', 47, 1234447788, 1, '111 One St', 'Chicago', 'IL', 'bjohnson_nurse'),
(16, 'Madison', 'Y', 'Ward', 29, 3334445566, 0, '23 N July St', 'Somewhere', 'AL', 'mward');

-- --------------------------------------------------------

--
-- Table structure for table `nurse_availability`
--

CREATE TABLE `nurse_availability` (
  `eid` int(11) NOT NULL,
  `the_date` varchar(20) NOT NULL,
  `time_slot` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurse_availability`
--

INSERT INTO `nurse_availability` (`eid`, `the_date`, `time_slot`) VALUES
(1, '12/01/2023', '9:00am'),
(4, '12/01/2023', '9:00am'),
(5, '12/01/2023', '10:00am'),
(5, '12/01/2023', '11:00am'),
(5, '12/01/2023', '1:00pm'),
(5, '12/01/2023', '2:00pm'),
(5, '12/01/2023', '3:00pm'),
(5, '12/01/2023', '4:00pm'),
(5, '12/01/2023', '5:00pm'),
(5, '12/01/2023', '9:00am'),
(6, '12/01/2023', '9:00am'),
(7, '12/01/2023', '9:00am'),
(8, '12/01/2023', '9:00am'),
(9, '12/01/2023', '6:00pm'),
(9, '12/01/2023', '8:00am'),
(9, '12/01/2023', '9:00am'),
(10, '12/01/2023', '9:00am'),
(11, '12/01/2023', '9:00am'),
(12, '12/01/2023', '11:00am'),
(12, '12/01/2023', '9:00am'),
(13, '12/01/2023', '9:00am'),
(14, '12/01/2023', '9:00am'),
(15, '12/01/2023', '10:00am'),
(16, '12/01/2023', '1:00pm');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `ssn` tinyint(4) NOT NULL,
  `Fname` varchar(8) DEFAULT NULL,
  `MI` varchar(1) DEFAULT NULL,
  `Lname` varchar(8) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `street_name` varchar(12) DEFAULT NULL,
  `direction` varchar(1) DEFAULT NULL,
  `building_number` smallint(6) DEFAULT NULL,
  `city` varchar(13) DEFAULT NULL,
  `state_initials` varchar(2) DEFAULT NULL,
  `zip_code` mediumint(9) DEFAULT NULL,
  `phone_number` bigint(20) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `race` varchar(16) DEFAULT NULL,
  `occupation_class` varchar(8) DEFAULT NULL,
  `medical_history` varchar(56) DEFAULT NULL,
  `user_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`ssn`, `Fname`, `MI`, `Lname`, `age`, `street_name`, `direction`, `building_number`, `city`, `state_initials`, `zip_code`, `phone_number`, `gender`, `race`, `occupation_class`, `medical_history`, `user_name`) VALUES
(1, 'John', 'A', 'Doe', 30, 'Main St', 'N', 456, 'Springfield', 'IL', 62701, 1256267271, 1, 'Caucasian', 'Engineer', 'No significant medical history', 'jdoe123'),
(2, 'Alison', 'M', 'Johnson', 25, 'Elm St', 'S', 123, 'Birmingham', 'AL', 35203, 1264909247, 0, 'African American', 'Teacher', 'Allergies: Peanuts, Medications: None', 'ajohnson123'),
(3, 'Robert', 'S', 'Wilson', 40, 'Oak Ave', 'N', 789, 'Denver', 'CO', 80204, 1257378382, 1, 'Caucasian', 'Doctor', 'No significant medical history', 'rwilson123'),
(4, 'Mary', 'L', 'Smith', 35, 'Elm St', 'E', 567, 'Los Angeles', 'CA', 90001, 1263798136, 0, 'Hispanic', 'Nurse', 'Hypertension, Diabetes, Medications: Lisinopril, Insulin', 'msmith123'),
(5, 'David', 'R', 'Thompson', 28, 'Oak St', 'W', 789, 'New York', 'NY', 10001, 1262687025, 1, 'Caucasian', 'Artist', 'No significant medical history', 'dthompson123'),
(6, 'Jennifer', 'M', 'Brown', 22, 'Elm Ave', 'S', 123, 'Chicago', 'IL', 60601, 1261575914, 0, 'African American', 'Student', 'Allergies: Pollen, Medications: None', 'jbrown123'),
(7, 'Daniel', 'L', 'Anderson', 40, 'Pine St', 'N', 456, 'Olympia', 'WA', 60610, 1260464813, 1, 'Asian', 'Lawyer', 'No significant medical history', 'danderson123'),
(8, 'Laura', 'K', 'Smith', 32, 'Elm Ave', 'S', 789, 'San Francisco', 'CA', 94101, 1259353802, 0, 'Hispanic', 'Chef', 'Allergies: Shellfish, Medications: Epinephrine', 'lsmith123'),
(9, 'John', 'C', 'Wilson', 38, 'Oak St', 'W', 567, 'Miami', 'FL', 33101, 1258243691, 1, 'African American', 'Engineer', 'No significant medical history', 'jwilson123'),
(10, 'Alice', 'L', 'Thompson', 29, 'Pine Ave', 'N', 123, 'Austin', 'TX', 78701, 1257142580, 0, 'Caucasian', 'Teacher', 'No significant medical history', 'athompson123'),
(35, 'Benjamit', 'B', 'Benster', 88, 'Chicago', 'N', 5, 'Seattle', 'WA', 90989, 7738918282, 1, 'N/A', 'N/A', 'N/A', 'bthagoat');

-- --------------------------------------------------------

--
-- Table structure for table `patient_vaccination_schedule`
--

CREATE TABLE `patient_vaccination_schedule` (
  `ssn` int(11) NOT NULL,
  `the_date` varchar(20) NOT NULL,
  `time_slot` varchar(20) NOT NULL,
  `vaccine_company` varchar(50) NOT NULL,
  `vaccine_name` varchar(50) NOT NULL,
  `dose_num` int(10) NOT NULL,
  `completed` int(11) NOT NULL,
  `nurse_eid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_vaccination_schedule`
--

INSERT INTO `patient_vaccination_schedule` (`ssn`, `the_date`, `time_slot`, `vaccine_company`, `vaccine_name`, `dose_num`, `completed`, `nurse_eid`) VALUES
(1, '12/01/2023', '9:00am', 'AstraZeneca', 'Flu', 1, 1, 10),
(5, '12/01/2023', '1:00pm', '', 'Yellow Fever', 0, 0, 0),
(5, '12/01/2023', '9:00am', '', 'Hepatitis B', 0, 0, 0),
(5, '12/01/2023', '8:00am', '', 'Polio', 0, 0, 0),
(5, '12/01/2023', '12:00pm', '', 'Hepatitis A', 0, 0, 0),
(5, '12/01/2023', '11:00am', '', 'COVID-19', 0, 0, 0),
(5, '12/01/2023', '3:00pm', '', 'TEST', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `the_date` varchar(20) NOT NULL,
  `time_slot` varchar(20) NOT NULL,
  `num_of_nurses` int(11) NOT NULL,
  `num_of_patients` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`the_date`, `time_slot`, `num_of_nurses`, `num_of_patients`) VALUES
('12/01/2023', '10:00am', 2, 1),
('12/01/2023', '11:00am', 2, 2),
('12/01/2023', '12:00pm', 0, 2),
('12/01/2023', '1:00pm', 2, 2),
('12/01/2023', '2:00pm', 1, 1),
('12/01/2023', '3:00pm', 1, 2),
('12/01/2023', '4:00pm', 1, 1),
('12/01/2023', '5:00pm', 1, 1),
('12/01/2023', '6:00pm', 1, 0),
('12/01/2023', '8:00am', 1, 2),
('12/01/2023', '9:00am', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `vaccine_name` varchar(21) NOT NULL,
  `vaccine_company` varchar(17) NOT NULL,
  `num_dose` tinyint(4) NOT NULL,
  `total_count` mediumint(9) NOT NULL,
  `num_available` smallint(6) NOT NULL,
  `num_on_hold` smallint(6) NOT NULL,
  `text_desc` varchar(56) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`vaccine_name`, `vaccine_company`, `num_dose`, `total_count`, `num_available`, `num_on_hold`, `text_desc`) VALUES
('covid-19 vaccine', 'Pfiser', 2, 1000, 1000, 0, 'this vaccine is for covid-19'),
('COVID19-Moderna', 'Moderna', 2, 100, 100, 0, 'COVID-19 vaccine produced by Moderna'),
('Flu', 'AstraZeneca', 1, 4998, 4800, 198, 'Influenza vaccine produced by AstraZeneca'),
('Hepatitis B', 'GSK', 3, 3000, 2799, 201, 'Hepatitis B vaccine produced by GSK'),
('Measles-Mumps-Rubella', 'Merck', 2, 6000, 5900, 100, 'MMR vaccine produced by Merck'),
('Polio', 'Sanofi', 1, 4000, 3949, 51, 'Polio vaccine produced by Sanofi'),
('Tetanus-Diphtheria', 'Johnson & Johnson', 1, 2000, 1900, 100, 'Tetanus-Diphtheria vaccine produced by Johnson & Johnson'),
('COVID-19', 'Johnson & Johnson', 1, 6000, 5899, 101, 'COVID-19 vaccine produced by Johnson & Johnson'),
('Hepatitis A', 'GSK', 2, 3000, 2799, 201, 'Hepatitis A vaccine produced by GSK'),
('Yellow Fever', 'Sanofi', 1, 1000, 949, 51, 'Yellow Fever vaccine produced by Sanofi'),
('TEST', 'TEST', 3, 150, 99, 51, 'TEST');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_delivery`
--

CREATE TABLE `vaccine_delivery` (
  `ID` int(11) NOT NULL,
  `dose_num` int(11) NOT NULL,
  `name` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_record`
--

CREATE TABLE `vaccine_record` (
  `patient_SSN` tinyint(4) DEFAULT NULL,
  `employee_ID` tinyint(4) DEFAULT NULL,
  `vaccine_name` varchar(21) DEFAULT NULL,
  `the_date` varchar(20) DEFAULT NULL,
  `dose_num` tinyint(4) DEFAULT NULL,
  `time_slot` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_record`
--

INSERT INTO `vaccine_record` (`patient_SSN`, `employee_ID`, `vaccine_name`, `the_date`, `dose_num`, `time_slot`) VALUES
(1, 10, 'Flu', '12/01/2023', 1, '9:00am');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_table`
--
ALTER TABLE `login_table`
  ADD PRIMARY KEY (`user_name`),
  ADD UNIQUE KEY `Email` (`Email`,`pass_word`) USING HASH;

--
-- Indexes for table `nurse`
--
ALTER TABLE `nurse`
  ADD PRIMARY KEY (`eid`),
  ADD UNIQUE KEY `eid` (`eid`,`Fname`,`Lname`,`age`,`phone_number`),
  ADD KEY `FK_user_name` (`user_name`);

--
-- Indexes for table `nurse_availability`
--
ALTER TABLE `nurse_availability`
  ADD PRIMARY KEY (`eid`,`the_date`,`time_slot`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`ssn`),
  ADD KEY `FK_user_name_p` (`user_name`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`the_date`,`time_slot`);

--
-- Indexes for table `vaccine_delivery`
--
ALTER TABLE `vaccine_delivery`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nurse`
--
ALTER TABLE `nurse`
  MODIFY `eid` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vaccine_delivery`
--
ALTER TABLE `vaccine_delivery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
