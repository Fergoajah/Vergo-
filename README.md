# Vergo-

Website ini digunakan untuk mencoba beberapa kerentanan yang ada, untuk tujuan pentesting.
## Getting Started
Siapkan beberapa database yang diperlukan:

Database Users
```
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100),
    alamat VARCHAR(100),
    role ENUM('admin', 'user'),
    last_seen_announcement TIMESTAMP
);
```

Database Messages
```
CREATE TABLE messages (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sender VARCHAR(50) NOT NULL,
    receiver VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Database Announcement
```
CREATE TABLE announcements (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    file_name VARCHAR(255),
    file_path VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

Database Announcement_reads
```
CREATE TABLE announcement_reads (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    announcement_id INT(11) NOT NULL,
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY(user_id),
    KEY(announcement_id)
);
```


Ikuti Langkah Langkah dibawah ini untuk melakukan instalasi:

### Prerequisites

Pastikan Anda telah menginstal software berikut sebelum memulai proyek:

1. **Web Server**: Apache atau Nginx.  
2. **PHP**: Versi 7.4 atau lebih baru
3. **Database**: MySQL atau MariaDB (versi 5.7 atau lebih baru).  
4. **Browser**: Modern browser yang mendukung HTML5, CSS3, dan JavaScript.  
5. **Git** (opsional): Untuk meng-clone repositori.  

Itu saja! Setelah ini, Anda bisa langsung melanjutkan ke langkah instalasi.


### Installation

Ini adalah step by step untuk melakukan clonning pada repo github

```
# Clone this repository
$ git clone https://github.com/Fergoajah/Vergo-.git

# Go into the repository
$ cd Vergo-
```

## Fitur
Ini adalah beberapa fitur yang saya tawarkan untuk bisa dicoba dalam melakukan pentesting

### Login Page
![image](https://github.com/user-attachments/assets/7b5cfb93-668b-4682-a852-c619ba64f8e0)

### Dashboard User
![image](https://github.com/user-attachments/assets/0073e92a-8361-4e7c-8d71-b99878404297)

### Dashboard Admin
![image](https://github.com/user-attachments/assets/f45da4ad-76ab-4703-86e6-f70cae37b352)

### Chat
![image](https://github.com/user-attachments/assets/cae40d41-06a5-4f47-931c-3a7fd9a4f8e3)

### Announcement Page
![image](https://github.com/user-attachments/assets/2caa9535-6b01-4b1c-a127-a4e98ffb68f9)

### Notification
![image](https://github.com/user-attachments/assets/4f9d7342-1b3d-4388-b87d-0f9cc3408d62)





