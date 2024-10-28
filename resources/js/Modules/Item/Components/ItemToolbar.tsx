import React from "react";
import { Button, Group, Menu, rem } from "@mantine/core";
import {
    IconPlus,
    IconChevronDown,
    IconGitBranch,
    IconFolderPlus,
    IconFileIsr,
    IconFolderUp,
    IconAdjustments,
    IconDeviceSdCard,
    IconArticle,
    IconListTree,
    IconTable,
    IconSelector,
    IconLayoutGrid,
} from "@tabler/icons-react";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { ItemParentResourceData } from "../Types/ItemParentResourceData";
import { Link } from "@inertiajs/react";
import CreateWorkflowForm from "@/Modules/Workflow/Forms/CreateWorkflowForm";
import { UpdateNumberingSchemeForm } from "@/Modules/NumberingScheme/Forms/UpdateNumberingSchemeForm";
import CreateNumberingSchemeForm from "@/Modules/NumberingScheme/Forms/CreateNumberingSchemeForm";
import CreateFolderForm from "@/Modules/Folder/Forms/FolderForm";
import UpdateWorkflowForm from "@/Modules/Workflow/Forms/UpdateWorkflowForm";

interface IProps {
    uploadFileRef?: React.RefObject<() => void>;
    itemParent?: ItemParentResourceData;
}

const ItemToolbar: React.FC<IProps> = ({ uploadFileRef, itemParent }) => {
    const { openModal } = useModalStore();

    return (
        <Group
            h="50%"
            px="md"
            align="center"
            justify="space-between"

        >
            <Group gap="xs">
                <Menu
                    shadow="md"
                    width={220}
                    transitionProps={{
                        transition: "pop-top-left",
                    }}
                    position="bottom-start"
                >
                    <Menu.Target>
                        <Button
                            variant="subtle"
                            color="dark.3"
                            leftSection={<IconPlus size={18} />}
                            rightSection={<IconChevronDown size={12} />}
                        >
                            New
                        </Button>
                    </Menu.Target>

                    <Menu.Dropdown>
                        <Menu.Item
                            leftSection={
                                <IconFolderPlus
                                    style={{
                                        width: rem(14),
                                        height: rem(14),
                                    }}
                                />
                            }
                            onClick={() => openModal("folder")}
                        >
                            New Folder
                        </Menu.Item>
                        <Menu.Item
                            leftSection={
                                <IconFileIsr
                                    style={{
                                        width: rem(14),
                                        height: rem(14),
                                    }}
                                />
                            }
                            onClick={() => uploadFileRef?.current?.()}
                        >
                            Upload Files
                        </Menu.Item>
                        <Menu.Item
                            leftSection={
                                <IconFolderUp
                                    style={{
                                        width: rem(14),
                                        height: rem(14),
                                    }}
                                />
                            }
                        >
                            Upload Folder
                        </Menu.Item>
                    </Menu.Dropdown>
                </Menu>

                <Button
                    variant="subtle"
                    component={Link}
                    href={route("folder.edit", { id: itemParent?.item_id })}
                    color="dark.3"
                    leftSection={<IconAdjustments size={18} />}
                >
                    Properties
                </Button>

                <Button
                    variant={itemParent?.workflow_id ? "light" : "subtle"}
                    color={itemParent?.workflow_id ? "green.8" : "dark.3"}
                    leftSection={<IconGitBranch size={18} />}
                    onClick={() => openModal(itemParent?.workflow_id ? "updateWorkflow" : "createWorkflow")}
                >
                    Workflow
                </Button>

                <Button
                    variant="subtle"
                    color="dark.3"
                    leftSection={<IconDeviceSdCard size={18} />}
                    component={Link}
                    href={route("folder.showRequiredMetadata", { id: itemParent?.item_id })}
                >
                    Metadata
                </Button>

                <Button
                    variant="subtle"
                    color="dark.3"
                    component={Link}
                    leftSection={<IconArticle size={18} />}
                    href={route("folder.activity-log", { id: itemParent?.item_id })}
                >
                    Activity
                </Button>

                <Button
                    variant={itemParent?.numbering_scheme_id ? "light" : "subtle"}
                    color={itemParent?.numbering_scheme_id ? "green.8" : "dark.3"}
                    leftSection={<IconListTree size={18} />}
                    onClick={() => openModal(itemParent?.numbering_scheme_id ? "updateNumberingScheme" : "createNumberingScheme")}
                >
                    Numbering
                </Button>

                <Button
                    variant="subtle"
                    color="dark.3"
                    leftSection={<IconTable size={18} />}
                >
                    Column
                </Button>
            </Group>

            <Group gap="xs">
                <Button
                    variant="subtle"
                    color="dark.3"
                    leftSection={<IconSelector size={18} />}
                    rightSection={<IconChevronDown size={12} />}
                >
                    Sort
                </Button>

                <Button
                    variant="subtle"
                    color="dark.3"
                    leftSection={<IconLayoutGrid size={18} />}
                    rightSection={<IconChevronDown size={12} />}
                >
                    View
                </Button>
            </Group>

            {/* Forms */}
            <CreateFolderForm itemParent={itemParent} />
            <CreateWorkflowForm itemParent={itemParent} />
            <UpdateWorkflowForm itemParent={itemParent} />
            <CreateNumberingSchemeForm itemParent={itemParent} />
            <UpdateNumberingSchemeForm itemParent={itemParent} />
        </Group>
    );
};

export default ItemToolbar;