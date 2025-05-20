CREATE TABLE Consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    data_consulta DATETIME,
    observacoes TEXT,
    status ENUM('pendente', 'confirmada', 'cancelada') DEFAULT 'pendente',
    FOREIGN KEY (cliente_id) REFERENCES Clientes(id)
);