Vagrant.configure("2") do |config|

    # Set up base box
    config.vm.box = "ubuntu/xenial64"

    # Set up static IP for VM
    config.vm.network "private_network", ip: "192.168.1.50"

    # Set up shared folders
    config.vm.synced_folder "./", "/var/www/iss-position", create: true, group: "www-data", owner: "www-data"

    # VM options
    config.vm.provider "virtualbox" do |v|
        v.name = "mhyndle-iss-position"
        v.customize ["modifyvm", :id, "--memory", "1024"]
    end

    # External shell provisioning
    config.vm.provision "shell", path: "vagrantConfig/vm-provision.sh"

end