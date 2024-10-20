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
import NumberingSchemeForm from "@/Modules/NumberingScheme/Forms/NumberingSchemeForm";
import CreateNumberingSchemeForm from "@/Modules/NumberingScheme/Forms/CreateNumberingSchemeForm";

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
            <div>
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
                    variant={itemParent?.has_active_workflow ? "light" : "subtle"}
                    color={itemParent?.has_active_workflow ? "green.8" : "dark.3"}
                    leftSection={<IconGitBranch size={18} />}
                    onClick={() => openModal("workflow")}
                >
                    Workflow
                </Button>

                <Button
                    variant="subtle"
                    color="dark.3"
                    leftSection={<IconDeviceSdCard size={18} />}
                >
                    Metadata
                </Button>

                <Button
                    variant="subtle"
                    color="dark.3"
                    leftSection={<IconArticle size={18} />}
                >
                    Activity
                </Button>

                <Button
                    variant={itemParent?.has_active_numbering_scheme ? "light" : "subtle"}
                    color={itemParent?.has_active_numbering_scheme ? "green.8" : "dark.3"}
                    leftSection={<IconListTree size={18} />}
                    onClick={() => openModal("numberingScheme")}
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
            </div>

            <div>
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
            </div>

            {/* Forms */}
            <CreateWorkflowForm itemParent={itemParent} />
            <CreateNumberingSchemeForm itemParent={itemParent} />
        </Group>
    );
};

export default ItemToolbar;