<?php
// ============================================================
//  View — Display Settings Page  (New Sinai MDI Hospital Admin)
//  Expects: $currentSpeed, $currentTop, $currentBottom,
//           $currentSpeedLabel, $currentTopLabel, $currentBottomLabel
// ============================================================
?>
<div class="page" id="page-display">
    <div class="section-card">
        <div class="section-card-header">
            <div class="section-card-title"><i class="bi bi-display"></i> Display Scroll Settings</div>
        </div>
        <div class="section-card-body">
            <div class="settings-grid">
                <div>
                    <label>Scroll Speed</label>
                    <select id="set-speed" class="setting-select">
                        <option value="15"  <?= $currentSpeed === 15  ? 'selected' : '' ?>>🐢 Slow</option>
                        <option value="25"  <?= $currentSpeed === 25  ? 'selected' : '' ?>>👍 Normal</option>
                        <option value="50"  <?= $currentSpeed === 50  ? 'selected' : '' ?>>⚡ Fast</option>
                    </select>
                    <div class="setting-hint">How quickly the list moves on screen</div>
                </div>
                <div>
                    <label>Wait Time at Top</label>
                    <select id="set-top" class="setting-select">
                        <option value="2000"  <?= $currentTop === 2000  ? 'selected' : '' ?>>2 seconds</option>
                        <option value="3000"  <?= $currentTop === 3000  ? 'selected' : '' ?>>3 seconds</option>
                        <option value="5000"  <?= $currentTop === 5000  ? 'selected' : '' ?>>5 seconds</option>
                        <option value="8000"  <?= $currentTop === 8000  ? 'selected' : '' ?>>8 seconds</option>
                        <option value="10000" <?= $currentTop === 10000 ? 'selected' : '' ?>>10 seconds</option>
                    </select>
                    <div class="setting-hint">Pause before scrolling down</div>
                </div>
                <div>
                    <label>Wait Time at Bottom</label>
                    <select id="set-bot" class="setting-select">
                        <option value="2000"  <?= $currentBottom === 2000  ? 'selected' : '' ?>>2 seconds</option>
                        <option value="3000"  <?= $currentBottom === 3000  ? 'selected' : '' ?>>3 seconds</option>
                        <option value="5000"  <?= $currentBottom === 5000  ? 'selected' : '' ?>>5 seconds</option>
                        <option value="8000"  <?= $currentBottom === 8000  ? 'selected' : '' ?>>8 seconds</option>
                        <option value="10000" <?= $currentBottom === 10000 ? 'selected' : '' ?>>10 seconds</option>
                    </select>
                    <div class="setting-hint">Pause before scrolling back up</div>
                </div>
            </div>

            <button class="btn-primary-custom" onclick="saveDisplaySettings()">
                <i class="bi bi-save"></i> Save Settings
            </button>

            <div class="summary-row mt-3">
                <strong style="font-size:13px;color:var(--muted);">Currently Active:</strong>
                <div class="summary-item">
                    <div class="s-lbl">Speed</div>
                    <div class="s-val" id="sum-speed"><?= htmlspecialchars($currentSpeedLabel) ?></div>
                </div>
                <div class="summary-item">
                    <div class="s-lbl">Pause Top</div>
                    <div class="s-val" id="sum-top"><?= htmlspecialchars($currentTopLabel) ?></div>
                </div>
                <div class="summary-item">
                    <div class="s-lbl">Pause Bottom</div>
                    <div class="s-val" id="sum-bot"><?= htmlspecialchars($currentBottomLabel) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>