# ============================================
#  Elena — Quick Deploy Script
#  Run:  .\deploy.ps1
#  Or:   .\deploy.ps1 -m "your commit message"
# ============================================
param(
    [string]$m = "deploy: update $(Get-Date -Format 'yyyy-MM-dd HH:mm')"
)

Write-Host "`n🚀 Elena — Deploy to Coolify" -ForegroundColor Cyan
Write-Host "================================`n" -ForegroundColor DarkGray

# 1. Stage all changes
Write-Host "📦 Staging changes..." -ForegroundColor Yellow
git add .

# 2. Commit
Write-Host "💾 Committing: $m" -ForegroundColor Yellow
git commit -m $m

if ($LASTEXITCODE -ne 0) {
    Write-Host "`n⚠️  Nothing to commit — working tree clean." -ForegroundColor DarkYellow
    $continue = Read-Host "Force push anyway? (y/N)"
    if ($continue -ne "y") { exit 0 }
}

# 3. Push
Write-Host "🌐 Pushing to GitHub..." -ForegroundColor Yellow
git push origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host "`n✅ Pushed to GitHub!" -ForegroundColor Green
    
    # Trigger Coolify via SSH (Bypassing Cloudflare)
    Write-Host "`n🚀 Triggering deployment on VPS..." -ForegroundColor Cyan
    ssh root@69.10.53.215 "docker exec -i coolify php -r 'include \""vendor/autoload.php\""; `$app = require_once \""bootstrap/app.php\""; `$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); `$app->make(App\Actions\Application\DeployApplication::class)->run(App\Models\Application::where(\""uuid\"", \""josgk00c0ook04cs8cck00c4\"")->first(), \""\"); '"
    
    Write-Host "`n🎉 Deployment started! Check your Coolify dashboard." -ForegroundColor Green
} else {
    Write-Host "`n❌ Push failed. Check your remote and credentials." -ForegroundColor Red
    exit 1
}
