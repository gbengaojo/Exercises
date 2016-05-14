-- Write the following queries

-- 1. Last ten payments by date, with customer name, payment date, check number and amount
SELECT paymentDate, customerName, checkNumber, amount FROM payments LEFT JOIN customers ON payments.customerNumber = customers.customerNumber ORDER BY paymentDate DESC LIMIT 10;

-- 2. Vintage Cars larger scale than 1:32
SELECT * FROM products WHERE SUBSTRING(productScale, 3) < 32;

-- 3. Customer Name, Phone, and total number of orders they've place
SELECT COUNT(orderNumber) AS TotalOrders, customers.customerName, phone FROM orders LEFT JOIN customers ON orders.customerNumber = customers.customerNumber GROUP BY customerName ORDER BY TotalOrders;

-- 4.  List of all customers with individual orders over $100
SELECT customers.customerNumber, orders.orderNumber, productCode, customerName FROM orderdetails LEFT JOIN orders ON orderdetails.orderNumber = orders.orderNumber LEFT JOIN customers ON orders.customerNumber = customers.customerNumber WHERE quantityOrdered * priceEach > 100.00;

-- 5. List of customers having more than 2 orders, and the date of their most recent order
SELECT COUNT(orderNumber) AS TotalOrders, orders.customerNumber, MAX(orderDate), customerName FROM orders LEFT JOIN customers ON orders.customerNumber = customers.customerNumber GROUP BY orders.customerNumber HAVING TotalOrders > 2;
