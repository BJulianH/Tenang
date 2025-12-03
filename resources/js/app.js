import './bootstrap';
// File: app.js
const express = require('express');
const nodemailer = require('nodemailer');
require('dotenv').config();  // untuk baca .env

const app = express();
app.use(express.json());

// 1. Setup Transporter dengan Gmail
const transporter = nodemailer.createTransport({
    service: 'gmail',  // Pakai service 'gmail'
    auth: {
        user: process.env.GMAIL_USER,      // Email Anda
        pass: process.env.GMAIL_APP_PASS   // App Password 16-digit
    }
});

// 2. Test koneksi (optional)
transporter.verify((error, success) => {
    if (error) {
        console.log('❌ Gmail connection error:', error);
    } else {
        console.log('✅ Gmail ready to send emails!');
    }
});

// 3. API Endpoint untuk Lupa Password
app.post('/api/forgot-password', async (req, res) => {
    try {
        const { email } = req.body;
        
        // Generate 6 digit token
        const token = Math.floor(100000 + Math.random() * 900000).toString();
        
        // Setup email
        const mailOptions = {
            from: `"Support Aplikasi" <${process.env.GMAIL_USER}>`,  // Tampilan pengirim
            to: email,  // Email penerima (user yang lupa password)
            replyTo: process.env.GMAIL_USER,  // Untuk user balas email
            subject: 'Reset Password - Aplikasi Anda',
            html: `
                <div style="font-family: Arial, sans-serif; max-width: 600px;">
                    <h2>Reset Password</h2>
                    <p>Kami menerima permintaan reset password untuk akun Anda.</p>
                    
                    <div style="background: #f4f4f4; padding: 20px; border-radius: 10px; margin: 20px 0;">
                        <h3>Kode Verifikasi Anda:</h3>
                        <div style="font-size: 36px; font-weight: bold; color: #2c3e50; letter-spacing: 5px;">
                            ${token}
                        </div>
                        <p style="color: #666; font-size: 14px;">Kode berlaku 1 jam</p>
                    </div>
                    
                    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
                    <hr>
                    <p style="color: #999; font-size: 12px;">
                        Email dikirim dari: ${process.env.GMAIL_USER}
                    </p>
                </div>
            `,
            // Versi text untuk email client sederhana
            text: `Reset Password\n\nKode verifikasi: ${token}\n\nKode berlaku 1 jam.\n\nEmail dari: ${process.env.GMAIL_USER}`
        };
        
        // 4. Kirim email
        const info = await transporter.sendMail(mailOptions);
        console.log('📧 Email sent:', info.messageId);
        
        // Simpan token ke database (ini contoh, sesuaikan dengan DB Anda)
        // await saveTokenToDatabase(email, token);
        
        res.json({
            success: true,
            message: 'Kode reset password telah dikirim ke email Anda'
        });
        
    } catch (error) {
        console.error('🔥 Error sending email:', error);
        
        // Handle error spesifik Gmail
        let errorMessage = 'Gagal mengirim email';
        
        if (error.code === 'EAUTH') {
            errorMessage = 'Email atau password salah. Pastikan pakai App Password!';
        } else if (error.code === 'EENVELOPE') {
            errorMessage = 'Alamat email tidak valid';
        } else if (error.responseCode === 550) {
            errorMessage = 'Email penerima tidak ditemukan';
        }
        
        res.status(500).json({
            success: false,
            message: errorMessage,
            detail: process.env.NODE_ENV === 'development' ? error.message : undefined
        });
    }
});

// 5. Jalankan server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`🚀 Server running on port ${PORT}`);
});