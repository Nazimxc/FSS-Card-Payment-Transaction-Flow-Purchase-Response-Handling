# **FSS Card Payment Flow Simulation (HDFC Payment Gateway)**

This project demonstrates a **simulated card purchase transaction flow** based on **FSS card processing architecture**, integrated with **HDFC Payment Gateway UAT**.
It is intended for **learning, understanding, and practicing payment gateway integration concepts** commonly used in banking and fintech environments.

---

## **Project Overview**

The project covers:

* Creation of an **encrypted card purchase request**
* Redirection to **HDFC Payment Gateway UAT**
* Handling and **decrypting the encrypted transaction response**
* Understanding **card authentication, authorization, and transaction status flow**

This setup helps in understanding how **merchant systems communicate securely with bank payment gateways**.

---

## **Files in This Repository**

### **1. Purchase Transaction (`purchase.php`)**

This file simulates a **merchant-initiated card payment request**.

**Key functionalities:**

* Builds a purchase request with:

  * Card details
  * Amount and currency
  * Merchant and transaction identifiers
* Encrypts the request data using:

  * **AES-256-GCM** (for migrated / modern flows)
  * **3DES (DES-EDE3)** for legacy compatibility
* Redirects the encrypted payload to the **HDFC Payment Gateway UAT endpoint**
* Simulates a real-world **merchant → payment gateway** transaction initiation

---

### **2. Decrypt Transaction Data (`decrypt_response.php`)**

This file handles the **payment gateway response** received after transaction processing.

**Key functionalities:**

* Accepts encrypted transaction response data (`trandata`)
* Decrypts the response using:

  * **AES-256-GCM** or **3DES**, based on key length
* Extracts readable transaction details for:

  * Payment status
  * Authorization result
  * Transaction reference values
* Represents how merchants **validate and process payment results** before updating their systems

---

## **Concepts Covered**

* Card Payment Flow (Purchase Transaction)
* Authentication & Authorization Flow
* FSS Card Processing Basics
* Encryption & Decryption (AES / 3DES)
* Secure Server-to-Server Communication
* Payment Gateway UAT Testing

---

## **Tools & Technologies**

* PHP
* OpenSSL
* Payment Gateway APIs (HDFC Smart Gateway – UAT)
* Card Encryption Standards (AES, 3DES)
