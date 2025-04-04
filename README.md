# Jamf Module

Jamf integration for MunkiReport. This module provides a comprehensive interface for viewing and managing Jamf data within MunkiReport, including:

* Client tab with multiple sub-tabs for viewing detailed client Mac information
* 12 included widgets for data visualization
* Admin interface for server configuration and data management
* Automatic data synchronization with Jamf Pro

## Requirements

* php-curl module (install on Ubuntu/Debian with `sudo apt-get install php-curl`)
* Jamf Pro server (tested with version 10.4.1, compatible with 9.9x and above)
* Valid Jamf Pro API credentials

## Configuration

To enable the module, add the following information to your `.env` file:

```sh
JAMF_ENABLE="TRUE"
JAMF_SERVER="https://domain.jamfcloud.com/"
JAMF_USERNAME="read_only_user"
JAMF_PASSWORD="password"
JAMF_VERIFY_SSL="TRUE"
```

### SSL Verification

The `JAMF_VERIFY_SSL` setting controls SSL certificate verification when connecting to your Jamf server:

* Set to `TRUE` (default) for standard SSL verification
* Set to `FALSE` if using self-signed certificates

### Client Script Configuration

The Jamf client script (`scripts/jamf`) can be configured to control data collection frequency:

1. Set the `JamfCheck` preference in `/Library/Preferences/MunkiReport`:
   * Value in seconds (e.g., 3600 for hourly checks)
   * Set to 0 to disable automatic Jamf lookups
   * Defaults to 86400 (24 hours) if not set

   Example:

   ```sh
   # Set to check every hour
   sudo defaults write /Library/Preferences/MunkiReport JamfCheck -int 3600

   # Set to check every 6 hours
   sudo defaults write /Library/Preferences/MunkiReport JamfCheck -int 21600

   # Disable automatic checks
   sudo defaults write /Library/Preferences/MunkiReport JamfCheck -int 0
   ```

2. The script uses `cache/jamf.txt` to track last check time:
   * Stores Unix timestamp of last check
   * Creates new timestamp if file doesn't exist or contains invalid data
   * Only triggers Jamf lookup if enough time has elapsed since last check

## Features

### Admin Interface

* Located in Admin dropdown menu
* Verifies Jamf server connectivity and permissions
* Provides bulk data pull functionality (approximately 3 minutes for 500 Macs)
* Displays server configuration status

### Client Interface

* Responsive design similar to Jamf Pro
* Multiple sub-tabs for different data categories
* Direct links to Jamf Pro interface
* Pull new data from Jamf server

### Data Collection

* Comprehensive hardware and software inventory
* Management status and configuration profiles
* User and location information
* Security settings and compliance status
* Historical data and logs

## Table Schema

The module stores the following data types:

### Basic Information

* increments - id
* string - serial_number
* integer - jamf_id
* string - name
* string - mac_address
* string - alt_mac_address
* string - ip_address
* string - last_reported_ip
* string - jamf_version

### Management Status

* boolean - managed
* string - management_username
* text - management_password_sha256
* boolean - mdm_capable
* string - mdm_capable_users
* boolean - enrolled_via_dep
* boolean - user_approved_enrollment
* boolean - user_approved_mdm

### Timestamps

* bigInteger - report_date_epoch
* bigInteger - last_contact_time_epoch
* bigInteger - initial_entry_date_epoch
* bigInteger - last_cloud_backup_date_epoch
* bigInteger - last_enrolled_date_epoch

### Hardware Information

* string - model
* string - model_identifier
* string - processor_type
* integer - processor_speed
* integer - number_cores
* integer - number_processors
* integer - total_ram
* integer - available_ram_slots
* string - boot_rom
* string - smc_version
* string - nic_speed
* string - optical_drive

### Software Information

* string - os_version
* string - os_build
* string - processor_architecture
* string - sip_status
* string - xprotect_version
* text - unix_executables
* text - licensed_software
* text - installed_by_casper
* text - installed_by_installer_swu
* text - cached_by_casper
* text - available_software_updates
* text - running_services

### Security Settings

* string - disk_encryption_configuration
* text - filevault_2_users
* text - gatekeeper_status
* string - institutional_recovery_key
* boolean - master_password_set

### User and Location

* string - username
* text - realname
* string - email_address
* text - position
* string - phone
* text - department
* text - building
* string - room

### Asset Information

* text - barcode_1
* text - barcode_2
* text - asset_tag
* string - udid
* boolean - is_purchased
* boolean - is_leased
* string - po_number
* string - vendor
* string - applecare_id
* string - purchase_price
* string - purchasing_account
* bigInteger - po_date_epoch
* bigInteger - warranty_expires_epoch
* bigInteger - lease_expires_epoch
* integer - life_expectancy

### Management Data

* integer - comands_completed
* integer - comands_pending
* integer - comands_failed
* string - purchasing_contact
* boolean - ble_capable
* string - active_directory_status
* text - computer_group_memberships

### JSON-Stored Data

* longText - certificates
* longText - attachments
* longText - storage
* longText - applications
* longText - mapped_printers
* longText - computer_usage_logs_history
* longText - audits_history
* longText - policy_logs_history
* longText - casper_remote_logs_history
* longText - screen_sharing_logs_history
* longText - casper_imaging_logs_history
* longText - commands_history
* longText - user_location_history
* longText - mac_app_store_applications_history
* longText - policies_management
* longText - ebooks_management
* longText - mac_app_store_apps_management
* longText - managed_preference_profiles_management
* longText - restricted_software_management
* longText - smart_groups_management
* longText - static_groups_management
* longText - patch_reporting_software_titles_management
* longText - patch_policies_management
* longText - extension_attributes
* longText - local_accounts
* longText - user_inventories
* longText - configuration_profiles
* longText - peripherals
