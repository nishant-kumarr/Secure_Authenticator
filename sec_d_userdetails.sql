SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `your_database_name`

-- --------------------------------------------------------

-- Table structure for table `students`

CREATE TABLE `students` (
  `name` varchar(255) NOT NULL,
  `roll_number` int(11) NOT NULL,
  `section` varchar(10) NOT NULL,
  `attendance` char(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserting data for table `students`

INSERT INTO `students` (`name`, `roll_number`, `section`, `attendance`) VALUES
('John Doe', 101, 'D', 'A'),
('Jane Smith', 102, 'D', 'A'),
('Alice Johnson', 103, 'D', 'A'),
('Bob Brown', 104, 'D', 'A'),
('Emily Davis', 105, 'D', 'A'),
('Michael Wilson', 106, 'D', 'A'),
('Sarah Garcia', 107, 'D', 'A'),
('David Martinez', 108, 'D', 'A'),
('Olivia Robinson', 109, 'D', 'A'),
('James Lee', 110, 'D', 'A');

-- Indexes for dumped tables

-- Indexes for table `students`
ALTER TABLE `students`
  ADD PRIMARY KEY (`roll_number`);

-- AUTO_INCREMENT for dumped tables

-- AUTO_INCREMENT for table `students`
ALTER TABLE `students`
  MODIFY `roll_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
