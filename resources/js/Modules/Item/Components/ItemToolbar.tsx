import React from "react";
import { ActionIcon, Button, Group, Menu, Tooltip, rem } from "@mantine/core";
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
    IconFileReport,
} from "@tabler/icons-react";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { ItemParentResourceData } from "../Types/ItemParentResourceData";
import { Link } from "@inertiajs/react";
import CreateWorkflowForm from "@/Modules/Workflow/Forms/CreateWorkflowForm";
import { UpdateNumberingSchemeForm } from "@/Modules/NumberingScheme/Forms/UpdateNumberingSchemeForm";
import CreateNumberingSchemeForm from "@/Modules/NumberingScheme/Forms/CreateNumberingSchemeForm";
import CreateFolderForm from "@/Modules/Folder/Forms/FolderForm";
import UpdateWorkflowForm from "@/Modules/Workflow/Forms/UpdateWorkflowForm";
import useGenerateReport from "@/Modules/Common/Hooks/use-generate-report";

interface IProps {
    uploadFileRef?: React.RefObject<() => void>;
    itemParent?: ItemParentResourceData;
}

const ItemToolbar: React.FC<IProps> = ({ uploadFileRef, itemParent }) => {
    const { openModal } = useModalStore();
    const { generateReport } = useGenerateReport();

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
                        {/* <Tooltip label="New" position="bottom" withArrow>
                            <ActionIcon variant="transparent" color="dark.3">
                                <IconPlus size={18} />
                                <IconChevronDown size={12} style={{ marginLeft: rem(4) }} />
                            </ActionIcon>
                        </Tooltip> */}
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

                <Tooltip label="Properties" position="bottom" withArrow>
                    <ActionIcon
                        component={Link}
                        size="lg"
                        href={route("folder.edit", { id: itemParent?.item_id })}
                        variant="transparent"
                        color="dark.3"
                    >
                        <IconAdjustments size={18} />
                    </ActionIcon>
                </Tooltip>

                <Tooltip label="Workflow" position="bottom" withArrow>
                    <ActionIcon
                        variant="transparent"
                        size="lg"
                        color={itemParent?.workflow_id ? "green.8" : "dark.3"}
                        onClick={() => openModal(itemParent?.workflow_id ? "updateWorkflow" : "createWorkflow")}
                    >
                        <IconGitBranch size={18} />
                    </ActionIcon>
                </Tooltip>

                <Tooltip label="Metadata" position="bottom" withArrow>
                    <ActionIcon
                        component={Link}
                        size="lg"
                        href={route("folder.showRequiredMetadata", { id: itemParent?.item_id })}
                        variant="transparent"
                        color={itemParent?.required_metadata?.length ? "green.8" : "dark.3"}
                    >
                        <IconDeviceSdCard size={18} />
                    </ActionIcon>
                </Tooltip>

                <Tooltip label="Activity" position="bottom" withArrow>
                    <ActionIcon
                        component={Link}
                        size="lg"
                        href={route("folder.activity-log", { id: itemParent?.item_id })}
                        variant="transparent"
                        color="dark.3"
                    >
                        <IconArticle size={18} />
                    </ActionIcon>
                </Tooltip>

                <Tooltip label="Numbering" position="bottom" withArrow>
                    <ActionIcon
                        size="lg"
                        variant="transparent"
                        color={itemParent?.numbering_scheme_id ? "green.8" : "dark.3"}
                        onClick={() => openModal(itemParent?.numbering_scheme_id ? "updateNumberingScheme" : "createNumberingScheme")}
                    >
                        <IconListTree size={18} />
                    </ActionIcon>
                </Tooltip>

                <Tooltip label="Column" position="bottom" withArrow>
                    <ActionIcon
                        variant="transparent"
                        color="dark.3"
                        size="lg"
                        onClick={() => openModal("selectMetadataColumns")}
                    >
                        <IconTable size={18} />
                    </ActionIcon>
                </Tooltip>

                <Tooltip label="Report" position="bottom" withArrow>
                    <ActionIcon
                        variant="transparent"
                        color="dark.3"
                        size="lg"
                        onClick={() => generateReport(itemParent?.item_id ?? "")}
                    >
                        <IconFileReport size={18} />
                    </ActionIcon>
                </Tooltip>
            </Group>

            <Group gap="xs">
                <Tooltip label="Sort" position="bottom" withArrow>
                    <ActionIcon variant="transparent" color="dark.3" size="lg">
                        <IconSelector size={18} />
                        <IconChevronDown size={12} style={{ marginLeft: rem(4) }} />
                    </ActionIcon>
                </Tooltip>

                <Tooltip label="View" position="bottom" withArrow>
                    <ActionIcon variant="transparent" color="dark.3" size="lg">
                        <IconLayoutGrid size={18} />
                        <IconChevronDown size={12} style={{ marginLeft: rem(4) }} />
                    </ActionIcon>
                </Tooltip>
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