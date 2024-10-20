import { CreateNumberingSchemeData } from "@/Modules/NumberingScheme/Types/CreateNumberingSchemeData";
import { useForm } from "@inertiajs/react";
import {
    Button,
    Flex,
    Group,
    Modal,
    Radio,
    Stack,
    Text,
    Textarea,
    TextInput,
} from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import { IconListTree } from "@tabler/icons-react";
import axios from "axios";
import React, { FormEventHandler } from "react";

interface IFormProps {
    isOpened: boolean;
    close: () => void;
    folderItemId?: string;
}

const ApprovalForm: React.FC<IFormProps> = ({ isOpened, close, folderItemId }) => {
    const { data, setData, post, processing, errors, reset } = useForm<CreateNumberingSchemeData>({
        folder_item_id: "",
        name: "",
        prefix: "",
    });

    // useEffect(() => {
    //     if (workflowType) {
    //         fetchUsers(workflowType);
    //     }
    // }, [workflowType]);

    // const fetchUsers = async (type: string) => {
    //     try {
    //         const response = await axios.get(`/numbering-scheme/api/{}`);
    //         setUsers(response.data);
    //     } catch (error) {
    //         console.error("Error fetching users", error);
    //     }
    // };


    const createFolderSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.folder_item_id = folderItemId ?? "";

        post(route("numbering-scheme.store"), {
            preserveScroll: true,
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Numbering scheme created",
                    color: "green",
                });
            },
            onError: () => {
                close();
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Create Document Numbering
                </Text>
            }
            size={550}
        >
            <form onSubmit={createFolderSubmit}>
                <Stack gap={16}>
                    <Text size="sm" c="dimmed">
                        You can set up a numbering scheme for files in this folder.
                    </Text>
                    <Radio.Group name="status" defaultValue="active">
                        <Group mt="xs">
                            <Radio value="active" label="Active" />
                            <Radio value="inactive" label="Inactive" />
                        </Group>
                    </Radio.Group>

                    <TextInput
                        id="numbering_name"
                        type="text"
                        name="numbering_name"
                        label="Numbering Name"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />

                    <Textarea
                        label="Prefix"
                        autosize
                        minRows={2}
                        maxRows={4}
                        value={data.prefix}
                        onChange={(e) => setData("prefix", e.target.value)}
                        error={errors.prefix}
                    />

                    <TextInput id="preview" type="text" name="preview" label="Preview" readOnly />
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

interface TrackingButtonProps {
    trackingActive?: boolean;
    folderItemId?: string;
}

const TrackingButton: React.FC<TrackingButtonProps> = ({ trackingActive, folderItemId }) => {
    const [createApprovalOpened, { open: openCreateApproval, close: closeCreateApproval }] =
        useDisclosure(false);

    return (
        <>
            <Button
                variant={trackingActive ? "light" : "subtle"}
                color={trackingActive ? "green.8" : "dark.3"}
                leftSection={<IconListTree size={18} />}
                onClick={openCreateApproval}
            >
                Numbering
            </Button>

            <ApprovalForm isOpened={createApprovalOpened} close={closeCreateApproval} folderItemId={folderItemId} />
        </>
    );
};

export default TrackingButton;
