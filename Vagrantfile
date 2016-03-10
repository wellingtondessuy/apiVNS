Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  config.vm.box_check_update = false

  config.vm.network "forwarded_port", guest: 80, host: 9998

  # config.vm.network "private_network", ip: "192.168.33.10"

  # config.vm.network "public_network"

  config.vm.synced_folder ".", "/vagrant"
  config.vm.synced_folder "../fcontrol", "/var/www"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "64"
  end

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.

  config.vm.provision "shell", path: "bootstrap.sh"
  # config.vm.provision "shell", path: "mysql.sh", args: [mysql_root_password, mysql_version, mysql_enable_remote, mysql_database_name]

end
