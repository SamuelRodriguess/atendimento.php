CREATE TABLE atendimento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    senha INT UNSIGNED,
    tipo ENUM('Normal', 'Prioritário')
);