# ============================================
#  Elena - Quick Deploy Script
#  Run:  .\deploy.ps1
#  Or:   .\deploy.ps1 -m "your commit message"
# ============================================
param(
    [string]$m = "deploy: update $(Get-Date -Format 'yyyy-MM-dd HH:mm')"
)

Write-Host "--- Elena: Deploying to Coolify ---" -ForegroundColor Cyan

# 1. Stage all changes
Write-Host "Staging changes..." -ForegroundColor Yellow
git add .

# 2. Commit
Write-Host "Committing: $m" -ForegroundColor Yellow
git commit -m $m

if ($LASTEXITCODE -ne 0) {
    Write-Host "Nothing to commit - working tree clean." -ForegroundColor DarkYellow
    $continue = Read-Host "Force push anyway? (y/N)"
    if ($continue -ne "y") { exit 0 }
}

# 3. Push
Write-Host "Pushing to GitHub..." -ForegroundColor Yellow
git push origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host "Pushed to GitHub!" -ForegroundColor Green
    
    # Trigger Coolify via SSH (Bypassing Cloudflare)
    Write-Host "Triggering deployment on VPS..." -ForegroundColor Cyan
    
    # Upload trigger script to VPS
    scp "trigger_deploy.php" root@69.10.53.215:/tmp/trigger_deploy.php
    
    # Run trigger script inside Coolify container
    ssh root@69.10.53.215 "docker cp /tmp/trigger_deploy.php coolify:/var/www/html/trigger_deploy.php && docker exec coolify php /var/www/html/trigger_deploy.php"
    
    Write-Host "Deployment started! Check your Coolify dashboard." -ForegroundColor Green
}
else {
    Write-Host "Push failed. Check your remote and credentials." -ForegroundColor Red
    exit 1
}

Write-Host "Done!" -ForegroundColor Cyan
