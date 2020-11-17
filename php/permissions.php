<?php

class Permissions {

    //? CLASS CONSTANTS

    // ................................... BITMASKING USER PERMISIONS .............................
    //                                     - To check if FLAG_1 is set ... $permissions & FLAG_1
    //                                     - To set FLAG_1             ... $permissions | FLAG_1
    //                                     - To unset FLAG_1           ... $permissions & ~FLAG_1
    //                                     - To invert permissions     ... ~$permissions
    //* FIRST 4 BITS OF THE FLAG
    public const Guest  = 0x1; // 1
    public const Member = 0x2; // 2
    public const Blog   = 0x4; // 4
    public const Admin  = 0x8; // 8
    //  SECOND 4 BITS OF THE FLAG           # THIRD 4 BITS OF THE FLAG             # FOURTH 4 BITS OF THE FLAG
    // const U_PERM_ = 0x10;      // 16     #const U_PERM_ = 0x100;     // 256     #const U_fourth= 0x100;     // 8192
    // const U_PERM_ = 0x20;      // 32     #const U_PERM_ = 0x200;     // 1024    #const U_Pfourth 0x200;     // 16384
    // const U_PERM_ = 0x40;      // 64     #const U_PERM_ = 0x400;     // 2048    #const U_Pfourth 0x400;     // 32768
    // const U_PERM_ = 0x80;      // 128    #const U_PERM_ = 0x800;     // 4096    #const U_PERM_ = 0x800;     // 65536

    //? CLASS MEMBER FIELDS

    private $all_user_permissions = ["Guest" => self::Guest, 
                                     "Member" => self::Member,
                                     "Blog" => self::Blog,
                                     "Admin" => self::Admin];

    private $user_permissions = 0;

    //? CLASS METHODS

    //* CONSTRUCTOR
    public function __construct($user_perms) {
        $this->user_permissions = $user_perms;  
        // $this->all_user_permissions = ["Guest" => self::Guest, 
        //                                "Member" => self::Member,
        //                                "Blog" => self::Blog,
        //                                "Admin" => self::Admin];
    }

    // DESTRUCTOR ... no memory managements issues

    //* METHOD TO GET LIST OF PERMISSIONS
    public function getUserPermissionDecoded() {
        $str_permissions = "";
        foreach ( $this->all_user_permissions as $key => $value) {
            if ( $this->checkPermision($this->user_permissions, $value) ) {
                $str_permissions .= $key . " ";
            }
        }
        return trim($str_permissions);
    }

    //* METHOD TO RETURN BOOLEAN for member permission check
    public function IsGuest() {
        return ($this->checkPermission (self::Guest));
    }

    //* METHOD TO RETURN BOOLEAN for member permission check
    public function IsMember() {
        return ($this->checkPermission (self::Member));
    }

    //* METHOD TO RETURN BOOLEAN for admin permission check
    public function IsBlog() {
        return ($this->checkPermission (self::Blog));
    }

    //* METHOD TO RETURN BOOLEAN for admin permission check
    public function IsAdmin() {
        return ($this->checkPermission (self::Admin));
    }

    //* METHOD TO CHECK IF USER HAS A SPECIFIED PERMISSION I.E $TARGET_PERMISSION               
    private function checkPermission ($target_permission) {    
        $retValue = FALSE;
        if ( $this->IsActivePerm ($target_permission) ) {
            $retValue = ($this->user_permissions & $target_permission);
        }
        return $retValue;
    }// END OF FUNCTION CHECKPERMISION

    //* METHOD TO SET BIT OF A PERMISSION IN USER PERMISSIONS FLAG
    public function addPermission ( $target_permission ) {
        $retValue = FALSE;
        if ( $this->IsActivePerm ($target_permission) ) {
            $this->user_permissions = $this->user_permissions | $target_permission ;
            // return new permissions value
            $retValue = $this->user_permissions;
        }
        return $retValue;
    }// END OF FUNCTION ADDPERMISSION 

    //* METHOD TO SET BIT OF A PERMISSION IN USER PERMISSIONS FLAG
    public function removePermission ( $target_permission ) {
        $retValue = FALSE;
        if ( $this->checkPermision ($target_permission) ) {
            $this->user_permissions = $this->user_permissions & ~$target_permission ;
            // return new permissions value
            $retValue = $this->user_permissions;
        }
        return $retValue;
    }// END OF FUNCTION REMOVEPERMISSION

    //* METHOD TO DETERMINE IF TARGET PERMISSION IS IN USE
    private function IsActivePerm ($target_permission) {
        $retValue = FALSE;
        foreach ($this->all_user_permissions as $key => $value) {
            if ($value == $target_permission) {
                $retValue = TRUE;
                break;
            }
        }
        return $retValue;
    }// END OF FUNCTION ISACTIVEPERM

    //* METHOD TO GET USER PERMISSION VALUE
    // public function getUserPermission() {
    //     return $this->user_permission;
    // }
    
    //* METHOD TO PUBLISH THE ARRAY OF ACTIVE PERMISSIONS
    // public function getPermisisons() : iterable {
    //     $active_user_permissions = $all_user_permissions;
    //     return $this->user_perms;
    // }

}// END OF CLASS PERMISSIONS

//? WRAPPER FUNCTIONS
function HasMemberAccess($user_permissions) {
    $perms_obj = new Permissions($user_permissions);
    return $perms_obj->IsMember();
}

function HasAdminAccess($user_permissions) {
    $perms_obj = new Permissions($user_permissions);
    return $perms_obj->IsAdmin();
}

?>