# Vergo-

Website ini digunakan untuk mencoba beberapa kerentanan yang ada, untuk tujuan sebagai lab atau target serangan untuk uji coba pentesting.
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
![image](https://github.com/user-attachments/assets/4355d948-f14c-4bee-90b2-9e5ebeeebe6c)

### Registration Page
![image](https://github.com/user-attachments/assets/aff5b33b-de1a-4a8b-9c49-41f60afc78ec)

### Dashboard User
![image](https://github.com/user-attachments/assets/c5221143-3c46-477d-aa47-9f7f2b9dd541)

### Dashboard Admin
![image](https://github.com/user-attachments/assets/74a68332-fae8-45ec-9290-aec8951c0033)

### Chat
![image](https://github.com/user-attachments/assets/20ce720f-8c38-42e8-b324-0d748db7426f)

### Announcement Page
![image](https://github.com/user-attachments/assets/0f7cf819-49e9-4952-b671-253096854319)

### Notification
![image](https://github.com/user-attachments/assets/acfb6400-b6f6-4d8c-8fa8-252a81e073f4)

### Notification Detail
![image](https://github.com/user-attachments/assets/5280f92b-a9e1-48da-acb3-ea4b852c8b50)




