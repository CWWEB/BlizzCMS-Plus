    <section class="uk-section uk-section-xsmall uk-padding-remove slider-section">
      <div class="uk-background-cover uk-height-small header-section"></div>
    </section>
    <section class="uk-section uk-section-xsmall main-section" data-uk-height-viewport="expand: true">
      <div class="uk-container">
        <div class="uk-grid uk-grid-medium" data-uk-grid>
          <div class="uk-width-1-4@m">
            <ul class="uk-nav uk-nav-default myaccount-nav">
              <?php if($this->wowmodule->getModule(8) == '1'): ?>
              <li class="uk-active"><a href="<?= base_url('panel'); ?>"><i class="fas fa-user-circle"></i> <?= $this->lang->line('tab_account'); ?></a></li>
              <?php endif; ?>
              <li class="uk-nav-divider"></li>
              <?php if($this->wowmodule->getModule(13) == '1'): ?>
              <li><a href="<?= base_url('donate'); ?>"><i class="fas fa-hand-holding-usd"></i> <?=$this->lang->line('navbar_donate_panel'); ?></a></li>
              <?php endif; ?>
              <?php if($this->wowmodule->getModule(14) == '1'): ?>
              <li><a href="<?= base_url('vote'); ?>"><i class="fas fa-vote-yea"></i> <?=$this->lang->line('navbar_vote_panel'); ?></a></li>
              <?php endif; ?>
              <?php if($this->wowmodule->getModule(12) == '1'): ?>
              <li><a href="<?= base_url('store'); ?>"><i class="fas fa-store"></i> <?=$this->lang->line('tab_store'); ?></a></li>
              <?php endif; ?>
              <li class="uk-nav-divider"></li>
              <?php if($this->wowmodule->getModule(16) == '1'): ?>
              <li><a href="<?= base_url('bugtracker'); ?>"><i class="fas fa-bug"></i> <?=$this->lang->line('tab_bugtracker'); ?></a></li>
              <?php endif; ?>
              <?php if($this->wowmodule->getModule(17) == '1'): ?>
              <li><a href="<?= base_url('changelogs'); ?>"><i class="fas fa-scroll"></i> <?=$this->lang->line('tab_changelogs'); ?></a></li>
              <?php endif; ?>
            </ul>
          </div>
          <div class="uk-width-3-4@m">
            <h4 class="uk-h4 uk-text-uppercase uk-text-bold"><?= $this->lang->line('profile_username'); ?> <?= $this->wowauth->getUsernameID($idlink); ?></h4>
            <div class="uk-card-default myaccount-card uk-margin-small">
              <div class="uk-card-header">
                <div class="uk-grid uk-grid-small">
                  <div class="uk-width-expand@m">
                    <h5 class="uk-h5 uk-text-uppercase uk-text-bold"><i class="fas fa-info-circle"></i> </h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="uk-card-default myaccount-card uk-margin-small">
              <div class="uk-card-header">
                <h5 class="uk-h5 uk-text-uppercase uk-text-bold"><i class="fas fa-users"></i> <?= $this->lang->line('panel_chars_list'); ?></h5>
              </div>
              <div class="uk-card-body">
                <div class="uk-grid uk-child-width-1-1 uk-margin-small" data-uk-grid>
                  <?php foreach ($this->wowrealm->getRealms()->result() as $charsMultiRealm):
                    $multiRealm = $this->wowrealm->realmConnection($charsMultiRealm->username, $charsMultiRealm->password, $charsMultiRealm->hostname, $charsMultiRealm->char_database);
                  ?>
                  <div>
                    <h5 class="uk-h5 uk-text-bold"><i class="fas fa-server"></i> <?= $this->wowrealm->getRealmName($charsMultiRealm->realmID); ?></h5>
                    <div class="uk-overflow-auto uk-width-1-1 uk-margin-small">
                      <table class="uk-table uk-table-divider uk-table-small">
                        <thead>
                          <tr>
                            <th class="uk-table-expand"><i class="fas fa-user"></i> <?= $this->lang->line('table_header_name'); ?></th>
                            <th class="uk-table-expand"><i class="fas fa-info-circle"></i> <?= $this->lang->line('table_header_race'); ?>/<?= $this->lang->line('table_header_class'); ?></th>
                            <th class="uk-width-small"><i class="fas fa-level-up-alt"></i> <?= $this->lang->line('table_header_level'); ?></th>
                            <th class="uk-table-expand"><i class="fas fa-clock"></i> <?= $this->lang->line('table_header_time_played'); ?></th>
                            <th class="uk-table-expand"><i class="fas fa-coins"></i> <?= $this->lang->line('table_header_money'); ?></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($this->wowrealm->getGeneralCharactersSpecifyAcc($multiRealm , $idlink)->result() as $chars): ?>
                          <tr>
                            <td><?= $chars->name ?></td>
                            <td>
                              <img class="uk-border-rounded" src="<?= base_url('assets/images/races/'.$this->wowgeneral->getRaceIcon($chars->race)); ?>" width="20" height="20" title="<?= $this->wowgeneral->getRaceName($chars->race); ?>" alt="">
                              <img class="uk-border-rounded" src="<?= base_url('assets/images/class/'.$this->wowgeneral->getClassIcon($chars->class)); ?>" width="20" height="20" title="<?= $this->wowgeneral->getClassName($chars->class); ?>" alt="">
                            </td>
                            <td><?= $chars->level ?></td>
                            <td><?= $this->wowgeneral->timeConversor($chars->totaltime); ?></td>
                            <td><?= $this->wowgeneral->moneyConversor($chars->money)['gold']; ?>g <?= $this->wowgeneral->moneyConversor($chars->money)['silver']; ?>s <?= $this->wowgeneral->moneyConversor($chars->money)['copper']; ?>c</td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>