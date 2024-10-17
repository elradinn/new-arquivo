import { useForm } from "@inertiajs/react";
import {
    Avatar,
    Badge,
    Button,
    Flex,
    Group,
    Input,
    Modal,
    Paper,
    Radio,
    Stack,
    Switch,
    Text,
    Textarea,
} from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import { IconGitBranch } from "@tabler/icons-react";
import axios from "axios";
import { DataTable } from "mantine-datatable";
import { FormEventHandler, useEffect, useState } from "react";
import ItemIcon from "@/Modules/Item/Components/ItemIcon";
import useModalStore from "../../Hooks/use-modal-store";
import { UserResourceData } from "@/Modules/User/Types/UserResourceData";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";
import { CreateWorkflowData } from "@/Modules/Workflow/Types/CreateWorkflowData";

interface IFormProps {
    isOpened: boolean;
    close: () => void;
    itemParent?: ItemParentResourceData;
}


interface ModalProps {
    isOpened: boolean;
    close: () => void;
    file_id?: string[];
    onFolderSelect: (folderName: string, folderId: string) => void;
}

const MoveFileModal: React.FC<ModalProps> = ({ isOpened, close, onFolderSelect }) => {
    const [folderContents, setFolderContents] = useState([]);

    const { data } = useForm({
        file_id: "",
        destination_id: "",
    });

    useEffect(() => {
        if (isOpened) {
            loadFolderContents(1, "1");
        }
    }, [isOpened]);

    const loadFolderContents = (is_folder: number, folderId: string) => {
        if (!is_folder) {
            return;
        }

        axios
            .get(`/api/folder/${folderId}/contents`)
            .then((response) => {
                setFolderContents(response.data.contents);
                data.destination_id = folderId;
            })
            .catch(() => {
                notifications.show({
                    message: "Error fetching folder contents",
                    color: "red",
                });
            });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Move File
                </Text>
            }
            size={550}
            overlayProps={{
                backgroundOpacity: 0.55,
            }}
        >
            {/* <form onSubmit={handleMove}> */}
            <DataTable
                textSelectionDisabled
                columns={[
                    {
                        accessor: "name",
                        render: ({ mime, is_folder, name }) => (
                            <Group align="center" gap={12}>
                                <ItemIcon mime={mime} isFolder={is_folder} />
                                <span>{name}</span>
                            </Group>
                        ),
                    },
                ]}
                records={folderContents}
                customRowAttributes={({ is_folder, id, name }) => ({
                    onDoubleClick: (e: MouseEvent) => {
                        if (e.button === 0) {
                            loadFolderContents(is_folder, id);

                            if (is_folder) {
                                onFolderSelect(name, id);
                            }
                        }
                    },
                })}
                highlightOnHover
            />

            <Flex align="end" justify="end" mt={16}>
                <Button ml={12} onClick={close}>
                    Select
                </Button>
            </Flex>
            {/* </form> */}
        </Modal>
    );
};

const ApprovalForm: React.FC<IFormProps> = ({ isOpened, close, itemParent }) => {
    const [checked, setChecked] = useState(false);
    const [selectedFolderName, setSelectedFolderName] = useState<string | null>(null);
    const [users, setUsers] = useState<UserResourceData[]>([]);
    const [moveFilesOpened, { open: openmoveFiles, close: closemoveFiles }] = useDisclosure(false);
    const [workflowType, setWorkflowType] = useState("reviewal");

    const { data, setData, post, processing, errors, reset } = useForm<CreateWorkflowData>({
        folder_item_id: "",
        resolution: "",
        destination: "",
        type: "reviewal", // initial value
        users: []
    });

    useEffect(() => {
        if (workflowType) {
            fetchUsers(workflowType);
        }
    }, [workflowType]);

    const fetchUsers = async (type: string) => {
        try {
            const response = await axios.get(`/workflows/api/users-by-workflow-type?type=${type}`);
            setUsers(response.data);
        } catch (error) {
            console.error("Error fetching users", error);
        }
    };

    const createApprovalSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.folder_item_id = itemParent?.item_id ?? "";

        data.users = users.map(user => ({ user_id: user.id }));

        post(route("workflows.store"), {
            preserveScroll: true,
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Approval process created",
                    color: "green",
                });
            },
            onError: () => {
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    const handleFolderSelect = (folderName: string, folderId: string) => {
        setSelectedFolderName(folderName);
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Create Approval Process
                </Text>
            }
            size={550}
        >
            <form onSubmit={createApprovalSubmit}>
                <Stack gap={16}>
                    <Text size="sm" c="dimmed">
                        Routinely directs any uploaded file in this folder through a predefined
                        approval workflow
                    </Text>

                    <Radio.Group
                        name="status"
                        value={data.type}
                        onChange={(value) => {
                            setData("type", value);
                            setWorkflowType(value);
                        }}
                    >
                        <Group mt="xs">
                            <Radio value="reviewal" label="Review" defaultChecked />
                            <Radio value="approval" label="Approval" />
                        </Group>
                    </Radio.Group>

                    <Textarea
                        label="Resolution"
                        placeholder="Your resolution for this approval"
                        value={data.resolution ?? ""}
                        onChange={(e) => setData("resolution", e.target.value)}
                        error={errors.resolution}
                        autosize
                        minRows={2}
                        maxRows={4}
                    />

                    <Text size="sm" fw={500} mb={-8}>
                        User in this workflow
                    </Text>
                    {users.map(user => (
                        <Paper withBorder radius="md" py={16} px={10}>
                            <Group key={user.id}>
                                <Avatar />
                                <Stack gap={8}>
                                    <Text size="sm">{user.name}</Text>
                                </Stack>
                            </Group>
                        </Paper>
                    ))}
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Create
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

interface ApprovalButtonProps {
    approvalActive?: boolean;
    itemParent?: ItemParentResourceData;
}

const ApprovalButton: React.FC<ApprovalButtonProps> = ({ approvalActive, itemParent }) => {
    const [createApprovalOpened, { open: openCreateApproval, close: closeCreateApproval }] =
        useDisclosure(false);

    const { openModal, modals, closeModal } = useModalStore();

    return (
        <>
            <Button
                variant={approvalActive ? "light" : "subtle"}
                color={approvalActive ? "green.8" : "dark.3"}
                leftSection={<IconGitBranch size={18} />}
                onClick={() => openModal("approval")}
            >
                Approval
            </Button>

            <ApprovalForm isOpened={modals["approval"]} close={() => closeModal("approval")} itemParent={itemParent} />
        </>
    );
};

export default ApprovalButton;
