<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sokappe') }}</title>

        <style>
            :root { 
                --primary: #3b82f6; --secondary: #10b981; --danger: #ef4444; --warning: #f59e0b;
                --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb; --gray-300: #d1d5db;
                --gray-400: #9ca3af; --gray-500: #6b7280; --gray-600: #4b5563; --gray-700: #374151;
                --gray-800: #1f2937; --gray-900: #111827;
            }
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { 
                font-family: 'Segoe UI', Tahoma, Arial, sans-serif; 
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh; display: flex; align-items: center; justify-content: center;
                color: var(--gray-800); line-height: 1.6;
            }
            
            .auth-container { 
                width: 100%; max-width: 480px; margin: 20px; 
                background: white; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                overflow: hidden;
            }
            
            .auth-header { 
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                color: white; text-align: center; padding: 40px 30px 30px;
            }
            .auth-header h1 { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
            .auth-header p { opacity: 0.9; font-size: 15px; }
            
            .auth-body { padding: 40px 30px; }
            
            .form-group { margin-bottom: 24px; }
            .form-label { 
                display: block; margin-bottom: 8px; font-weight: 600; 
                color: var(--gray-700); font-size: 14px;
            }
            .form-input { 
                width: 100%; padding: 14px 16px; border: 2px solid var(--gray-200); 
                border-radius: 12px; font-size: 15px; transition: all 0.3s;
                background: var(--gray-50);
            }
            .form-input:focus { 
                outline: none; border-color: var(--primary); 
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); background: white;
            }
            .form-input.error { border-color: var(--danger); background: #fef2f2; }
            
            .form-error { 
                color: var(--danger); font-size: 13px; margin-top: 6px; 
                display: flex; align-items: center; gap: 4px;
            }
            
            .btn { 
                display: inline-flex; align-items: center; justify-content: center; gap: 8px;
                padding: 14px 24px; border: none; border-radius: 12px; font-weight: 600;
                font-size: 15px; cursor: pointer; transition: all 0.3s; text-decoration: none;
            }
            .btn-primary { 
                background: linear-gradient(135deg, var(--primary), var(--secondary)); 
                color: white; width: 100%;
            }
            .btn-primary:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4); }
            .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
            .btn-outline { 
                background: transparent; color: var(--primary); 
                border: 2px solid var(--primary);
            }
            .btn-outline:hover { background: var(--primary); color: white; }
            
            .auth-footer { 
                text-align: center; padding: 20px 30px 30px; 
                border-top: 1px solid var(--gray-100);
            }
            .auth-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
            .auth-footer a:hover { text-decoration: underline; }
            
            .checkbox-group { display: flex; align-items: center; gap: 12px; margin: 20px 0; }
            .checkbox-group input[type="checkbox"] { 
                width: 18px; height: 18px; accent-color: var(--primary);
            }
            .checkbox-group label { margin: 0; font-size: 14px; color: var(--gray-600); }
            
            .success-message { 
                background: #dcfce7; color: #166534; padding: 12px 16px; 
                border-radius: 12px; margin-bottom: 20px; border: 1px solid #bbf7d0;
                display: flex; align-items: center; gap: 8px;
            }

            /* File Upload Styles */
            .file-upload { position: relative; display: inline-block; width: 100%; }
            .file-upload input[type="file"] { 
                position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; 
            }
            .file-upload-label { 
                display: flex; align-items: center; justify-content: center; gap: 8px;
                padding: 14px 16px; border: 2px dashed var(--gray-300); 
                border-radius: 12px; background: var(--gray-50); cursor: pointer;
                transition: all 0.3s; color: var(--gray-600);
            }
            .file-upload-label:hover { border-color: var(--primary); background: rgba(59, 130, 246, 0.05); }
            .file-preview { margin-top: 12px; text-align: center; }
            .file-preview img { max-width: 120px; max-height: 120px; border-radius: 8px; }
        </style>
    </head>
    <body>
        <div class="auth-container">
            @yield('content')
        </div>
    </body>
    </html>
